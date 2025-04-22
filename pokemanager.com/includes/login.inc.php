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
                    $texto_consulta_usuario = "SELECT t.id_pokemon FROM tiene t JOIN usuarios u ON t.id_usuario = :id_usuario";
                    $consulta_usuario = $pdo->prepare($texto_consulta_usuario);
                    $consulta_usuario->bindParam(':id_usuario', $usuario['id'], PDO::PARAM_INT);
                    $consulta_usuario->execute();
                    $pokemons_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($pokemons_usuario as $pokemon) {
                        $_SESSION['pokemons_usuario'][] = $pokemon['id_pokemon'];
                    }
                    
                    header("Location: ../index.php");
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
