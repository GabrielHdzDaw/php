<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username = trim($_POST['nombre_usuario_registro'] ?? '');
    $password = $_POST['contrasena_registro'] ?? '';
    $repetirPassword = $_POST['repetir_contrasena'] ?? '';
    $fechaNacimiento = $_POST['fecha_nacimiento'] ?? '';
    $emailRaw = trim($_POST['email'] ?? '');
    $repetirEmail = trim($_POST['repetir_email'] ?? '');

    // Verifica campos vacíos antes de validar el email
    if (empty($username) || empty($password) || empty($repetirPassword) || empty($fechaNacimiento) || empty($emailRaw) || empty($repetirEmail)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header('Location: ../error.php');
        exit;
    }

    // Valida el email
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $_SESSION['error'] = "El formato del email no es válido.";
        header('Location: ../error.php');
        exit;
    }

    // Procesa la fecha de nacimiento y calcula la edad
    $fechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
    $edad = date_diff(date_create($fechaNacimiento), date_create('now'))->y;
    if ($edad <= 14) {
        $_SESSION['error'] = "Debes tener más de 14 años para registrarte.";
        header('Location: ../error.php');
        exit;
    }

    // Verifica el formato de la contraseña
    $regex = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
    if (!preg_match($regex, $password)) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres e incluir letras y números.";
        header('Location: ../error.php');
        exit;
    }

    // Verifica coincidencia de contraseñas y correos
    if ($password !== $repetirPassword) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header('Location: ../error.php');
        exit;
    }

    if ($email !== $repetirEmail) {
        $_SESSION['error'] = "Los correos electrónicos no coinciden.";
        header('Location: ../error.php');
        exit;
    }

    // Procesa la foto de perfil
    $nombreDirectorio = "../img/profile/";
    if (is_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'])) {
        // Validaciones adicionales de seguridad para archivos
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $tipoArchivo = $_FILES['ruta_foto_perfil']['type'];

        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            $_SESSION['error'] = "Solo se permiten archivos de imagen (JPG, PNG, GIF, WebP).";
            header('Location: ../error.php');
            exit;
        }

        if ($_FILES['ruta_foto_perfil']['size'] > 5242880) { // 5MB máximo
            $_SESSION['error'] = "El archivo de imagen no puede superar los 5MB.";
            header('Location: ../error.php');
            exit;
        }

        $idUnico = time();
        $extension = pathinfo($_FILES['ruta_foto_perfil']['name'], PATHINFO_EXTENSION);
        $nombreFichero = $idUnico . "." . strtolower($extension);
        $rutaFoto = "img/profile/" . $nombreFichero;

        if (!move_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'], $nombreDirectorio . $nombreFichero)) {
            $_SESSION['error'] = "Error al subir la imagen.";
            header('Location: ../error.php');
            exit;
        }
    } else {
        $rutaFoto = "img/profile/profile_placeholder.png";
    }

    // Inserta el usuario en la base de datos
    try {
        require_once "conectar_db.inc.php";

        // Verificar si el usuario o email ya existen
        $checkQuery = "SELECT COUNT(*) FROM usuarios WHERE nombre = :nombre OR email = :email";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(":nombre", $username);
        $checkStmt->bindParam(":email", $email);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            $_SESSION['error'] = "El nombre de usuario o email ya están registrados.";
            header('Location: ../error.php');
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $texto_consulta = "INSERT INTO usuarios (nombre, fecha_nacimiento, email, contrasena, ruta_foto_perfil, is_admin) 
                           VALUES (:nombre, :fecha_nacimiento, :email, :contrasena, :ruta_foto, :is_admin)";

        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(":nombre", $username);
        $consulta->bindParam(":fecha_nacimiento", $fechaNacimiento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":contrasena", $hashedPassword);
        $consulta->bindParam(":ruta_foto", $rutaFoto);
        $is_admin = 0;
        $consulta->bindParam(":is_admin", $is_admin);

        $consulta->execute();

        $_SESSION['registro_exitoso'] = true;
        header('Location: ../index.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        header('Location: ../error.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Acceso no permitido.";
    header('Location: ../error.php');
    exit;
}
