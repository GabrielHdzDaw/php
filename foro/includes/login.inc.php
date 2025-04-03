<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    session_start(); 

    $username = $_POST['nombre'];
    $password = $_POST['contrasena'];

    try {
        require_once "conectar_db.inc.php";

        $texto_consulta = "SELECT * FROM usuarios WHERE nombre = :nombre";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(":nombre", $username);

        if ($consulta->execute()) {
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($password, $usuario['contrasena'])) {
                $_SESSION['started'] = true;
                $_SESSION['session_token'] = password_hash($username . date("dd/MM/YYYY"),  PASSWORD_BCRYPT);
                header("Location:../index.php");
                die();
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            print_r($consulta->errorInfo());
        }
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
}
