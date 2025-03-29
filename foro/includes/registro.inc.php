<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    session_start(); // Asegúrate de iniciar la sesión
    
    $username = $_POST['nombre'];
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $ruta_foto = 'img/default.jpg'; // Ruta por defecto

    // Procesar imagen primero
    if (is_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'])) {
        $nombreDirectorio = "img/";
        // Crear directorio si no existe
        if (!is_dir($nombreDirectorio)) {
            mkdir($nombreDirectorio, 0755, true);
        }
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['ruta_foto_perfil']['name'];
        $rutaDestino = $nombreDirectorio . $nombreFichero;
        
        if (move_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'], $rutaDestino)) {
            $ruta_foto = $rutaDestino; // Guardar ruta válida
        } else {
            die("Error al subir la imagen.");
        }
    }

    try {
        require_once "conectar_db.inc.php";
        
        $texto_consulta = "INSERT INTO usuarios (nombre, email, contrasena, ruta_foto_perfil) 
                          VALUES (:nombre, :email, :contrasena, :ruta_foto)";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(":nombre", $username);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":contrasena", $password);
        $consulta->bindParam(":ruta_foto", $ruta_foto);
        
        if ($consulta->execute()) {
            $_SESSION['started'] = true;
            header("Location:../hilo.php");
            die();
        } else {
            print_r($consulta->errorInfo());
        }
        
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
} else {
    header('Location: ../index.php');
}