<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PokéManager - Juego de coleccionables de Pokémon. Crea tus equipos y hazlos combatir.">
    <meta name="keywords" content="Pokémon, coleccionables, juego, PokéManager, combates">
    <meta name="author" content="Gabriel Hernández Collado">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles/dialogs.css" type="text/css">
    <link rel="stylesheet" href="styles/tabs.css" type="text/css">
    <link rel="stylesheet" href="styles/pokedex.css" type="text/css">
    <link rel="stylesheet" href="styles/style.css" type="text/css">
    <link rel="stylesheet" href="styles/sobres.css" type="text/css">
    <link rel="stylesheet" href="styles/combate.css" type="text/css">
    <link rel="stylesheet" href="styles/perfil.css" type="text/css">
    <link rel="stylesheet" href="styles/generaciones.css" type="text/css">
    <link rel="stylesheet" href="styles/admin.css" type="text/css">
    <script src="scripts/tabs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>PokéManager</title>
</head>

<body>
    <header class="dynamic-header">
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
                    echo "<div class='nav-usuario-contenedor'>";
                    echo "<p class='nav-usuario-nombre'>¡Hola, " . $_SESSION['user_info']['nombre'] . "!</p>";
                    echo "<img class='img-perfil-nav' src='" . $_SESSION['user_info']['ruta_foto_perfil'] . "'>";
                    echo '<a class="logout-a" href="includes/logout.inc.php"><button class="logout-button">Cerrar sesión</button></a>';
                    echo '</div>';
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

        </nav>
    </header>
    <dialog id="dialogoRegistro" class="dialogo-registro">
        <div class="dialogo-registro-contenedor">
            <img src="img/register_bg.jpg" alt="">
            <form action="includes/signup.inc.php" method="POST" class="formulario-registro" enctype="multipart/form-data">
                <h2>¡Bienvenid@ a PokéManager!</h2>
                <input type="text" name="nombre_usuario_registro" id="nombre_usuario_registro" placeholder="Nombre de usuario" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="text" name="repetir_email" id="repetir_email" placeholder="Repetir email" required>
                <input type="password" name="contrasena_registro" id="contrasena_registro"
                    placeholder="Contraseña" required
                    pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                    title="Mínimo 8 caracteres con letras y números">
                <input type="password" name="repetir_contrasena" id="repetir_contrasena" placeholder="Repetir contraseña" required>
                <label for="fecha_nacimiento">Introduce tu fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                    required max="2010-01-01"
                    title="Debes tener más de 14 años">
                <input type="file" name="ruta_foto_perfil" id="ruta_foto_perfil"
                    accept="image/*"
                    title="Solo se permiten imágenes">
                <button type="submit">Registrarse</button>
                <span id="botonCerrarRegistro">X</span>
            </form>
        </div>

    </dialog>