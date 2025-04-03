<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    session_start(); // Asegúrate de iniciar la sesión

    $username = $_POST['nombre'];
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $ruta_foto = 'img/default.jpg'; // Ruta por defecto

    if (is_uploaded_file($_FILES['fichero']['tmp_name'])) {
        $nombreDirectorio = "ficheros/";
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['fichero']['name'];
        move_uploaded_file($_FILES['fichero']['tmp_name'], $nombreDirectorio .
            $nombreFichero);
    } else
        print("No se ha podido subir el fichero\n");


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
            header("Location:../index.php");
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
