<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $username = $_POST['nombre'];
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    

    $nombreDirectorio = "../img/profile/";
    if (is_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'])) {
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['ruta_foto_perfil']['name'];
        $rutaFoto = "img/profile/" . $nombreFichero;
        move_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'], $nombreDirectorio . $nombreFichero);
    } else
        $rutaFoto = "img/profile/" . "default_user.png";


    try {
        require_once "conectar_db.inc.php";
        $texto_consulta = "INSERT INTO usuarios (nombre, email, contrasena, ruta_foto_perfil) 
                           VALUES (:nombre, :email, :contrasena, :ruta_foto)";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(":nombre", $username);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":contrasena", $password);
        $consulta->bindParam(":ruta_foto", $rutaFoto);
        $consulta->execute();
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
    header('Location: ../index.php');
   echo  $_FILES['ruta_foto_perfil']['tmp_name'];
} else {
    header('Location: ../index.php');
    echo "No se ha podido registrar el usuario";
}
