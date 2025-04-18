<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PokéManager - Juego de cartas coleccionables de Pokémon. Crea tus equipos y hazlos combatir.">
    <meta name="keywords" content="Pokémon, cartas, coleccionables, juego, PokéManager">
    <meta name="author" content="Gabriel Hernández Collado">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css" type="text/css">
    <link rel="stylesheet" href="styles/dialogs.css" type="text/css">
    <link rel="stylesheet" href="styles/tabs.css" type="text/css">
    <link rel="stylesheet" href="styles/pokedex.css" type="text/css">

    <title>PokéManager</title>
</head>

<body>
    <header>
        <nav>
            <div>
                <a href="index.php">
                    <div class="logo-banner-container">
                        <img src="img/logo.png" alt="logo" class="logo">
                    </div>
                </a>
            </div>
            <div>
                <?php
                if ($_SESSION['started'] ?? false) {
                    echo '<button><a href="includes/logout.inc.php">Cerrar sesión</a></button>';
                } else {
                ?>
                    <form action="includes/login.inc.php" method="POST" class="formulario-login">
                        <input type="text" name="nombre_usuario_login" id="nombre_usuario_login" placeholder="Nombre de usuario" required>
                        <input type="password" name="contrasena_login" id="contrasena_login" placeholder="Contraseña" required>
                        <button type="submit">Iniciar sesión</button>
                        <button type="button" id="botonRegistro">Registrarse</button>
                    </form>
                <?php
                }
                ?>

            </div>

            <!-- <div>
                <button><a href="">Crear Hilo</a></button>
            </div> -->
        </nav>
    </header>
    <dialog id="dialogoRegistro">
        <div class="dialogo-registro-contenedor">
            <img src="img/register_bg.jpg" alt="">
            <form action="includes/registro.inc.php" method="POST" class="formulario-registro" enctype="multipart/form-data">
                <h2>¡Bienvenid@ a PokéManager!</h2>
                <input type="text" name="nombre_usuario_registro" id="nombre_usuario_registro" placeholder="Nombre de usuario" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="contrasena_registro" id="contrasena_registro" placeholder="Contraseña" required>
                <input type="file" name="ruta_foto_perfil" id="ruta_foto_perfil">
                <button type="submit">Registrarse</button>
                <span id="botonCerrarRegistro">X</span>
            </form>
        </div>

    </dialog>