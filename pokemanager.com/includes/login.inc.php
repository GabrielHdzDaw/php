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
                    $texto_consulta_usuario = "SELECT t.id_pokemon FROM tiene t JOIN usuarios u ON t.id_usuario = :id_usuario;";
                    $consulta_usuario = $pdo->prepare($texto_consulta_usuario);
                    $consulta_usuario->bindParam(':id_usuario', $usuario['id'], PDO::PARAM_INT);
                    $consulta_usuario->execute();
                    $pokemons_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);

                    if (count($pokemons_usuario) > 0) {
                        foreach ($pokemons_usuario as $pokemon) {
                            $_SESSION['pokemons_usuario'][] = $pokemon;
                        }
                    }
                    if (isset($_SESSION['pokemons_usuario'])) {
                        $_SESSION['pokemons_usuario'] = array_map(function ($pokemon) {
                            return $pokemon['id_pokemon'];
                        }, $_SESSION['pokemons_usuario']);
                    }

                    $fechaActual = new DateTime(date("Y-m-d"));
                    $fechaLogin = ($usuario['ultimo_login'])
                        ? new DateTime($usuario['ultimo_login'])
                        : new DateTime('1970-01-01');
                    $diferencia = $fechaActual->diff($fechaLogin);

                    $sobres = $usuario['sobres'] + $diferencia->days;
                    $consulta_sobres = $pdo->prepare("UPDATE usuarios SET sobres = :sobres WHERE id = :id_usuario");
                    $consulta_sobres->bindParam(':sobres', $sobres, PDO::PARAM_INT);
                    $consulta_sobres->bindParam(':id_usuario', $usuario['id'], PDO::PARAM_INT);
                    $consulta_sobres->execute();
                    $_SESSION['user_info']['sobres'] = $sobres;
                    $consulta_ultimo_login = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id");
                    $consulta_ultimo_login->bindParam(':id', $usuario['id'], PDO::PARAM_INT);
                    $consulta_ultimo_login->execute();

                    header("Location: ../index.php");
                } else {
                    $_SESSION['error'] = "<p>Ha fallado la verificación.</p>";
                    header("Location: ../error.php");
                }
            } else {
                $_SESSION['error'] = "<p>Nombre de usuario o contraseña incorrectos.</p>";
                header("Location: ../error.php");
            }
        } else {
            $_SESSION['error'] = "<p>Error en la consulta.</p>";
            header("Location: ../error.php");
        }
    } catch (PDOException $e) {
        error_log("¡Error!: " . $e->getMessage());
    }
} else {
    $_SESSION['error'] = "<p>No se ha podido iniciar sesión.</p>";
    header("Location: ../error.php");
}
