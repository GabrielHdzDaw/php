<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username = trim($_POST['nombre_usuario_login'] ?? '');
    $password = $_POST['contrasena_login'] ?? '';

    try {
        require_once "conectar_db.inc.php";
        $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
        $consulta->bindParam(":nombre", $username);

        if ($consulta->execute()) {
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                if (password_verify($password, $usuario['contrasena'])) {
                    $_SESSION['started'] = true;
                    $_SESSION['session_token'] = password_hash($username . date("d/m/Y"), PASSWORD_BCRYPT);
                    $_SESSION['user_info'] = $usuario;
                    header("Location: ../index.php");
                    die();
                } else {
                    error_log("Falló password_verify()");
                }
            } else {
                error_log("Usuario no encontrado en BD");
            }
            echo "Nombre de usuario o contraseña incorrectos.";
        } else {
            error_log("Error en la consulta: " . print_r($consulta->errorInfo(), true));
        }
    } catch (PDOException $e) {
        error_log("¡Error!: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    echo "No se ha podido iniciar sesión.";
}
