<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    session_start();

    $username = trim($_POST['nombre_usuario_registro'] ?? '');
    $password = $_POST['contrasena_registro'] ?? '';
    $repetirPassword = $_POST['repetir_contrasena'] ?? '';
    $fechaNacimiento = $_POST['fecha_nacimiento'] ?? '';
    $fechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $repetirEmail = $_POST['repetir_email'] ?? '';

    if (empty($username) || empty($password) || empty($repetirPassword) || empty($fechaNacimiento) || empty($email) || empty($repetirEmail)) {
        header('Location: ../index.php');
        exit;
    }

    $regex = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


    $nombreDirectorio = "../img/profile/";
    if (is_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'])) {
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['ruta_foto_perfil']['name'];
        $rutaFoto = "img/profile/" . $nombreFichero;
        move_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'], $nombreDirectorio . $nombreFichero);
    } else
        $rutaFoto = "img/profile/" . "profile_placeholder.png";

    if (preg_match($regex, $password) && $password == $repetirPassword && $email == $repetirEmail) {
        
        try {
            require_once "conectar_db.inc.php";
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
        } catch (PDOException $e) {
            die("¡Error!: " . $e->getMessage());
        }
        header('Location: ../index.php');
    } else {
        header('Location: ../index.php');
        exit;
    }
} else {
    header('Location: ../index.php');
    echo "No se ha podido registrar el usuario";
}
