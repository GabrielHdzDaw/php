<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $usuario = $_POST['nombre_usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    try {
        require_once "conectar_db.inc.php";

        // $texto_consulta = "INSERT INTO usuarios (nombre_usuario, contrasena, email) VALUES (?, ?, ?)";
        $texto_consulta = "INSERT INTO usuarios (nombre_usuario, contrasena, email) VALUES (:usuario, :contrasena, :email)";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":contrasena", $contrasena);
        $consulta->bindParam(":email", $email);
        $consulta->execute();

        //Liberar recursos
        $pdo = null;
        $consulta = null;
        $_SESSION['iniciada'] = true;
        header("Location:../index.php");
        die();

    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage() . "<br/>");
    }
} else {
    header('Location: ../index.php');
}
