<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Foro</title>
</head>

<body>
    <h1>Foro</h1>
    <?php
    if (isset($_SESSION["started"])) {
    ?>
        <h3>Ya has iniciado sesión</h3>
    <?php
    } else {
    ?>
        <div>
            <h2>Registro</h2>
            <form action="includes/registro.inc.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Nombre de usuario">
                <input type="password" name="contrasena" placeholder="Contraseña">
                <input type="email" name="email" placeholder="Email">
                <label for="profile_picture">Foto de perfil</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="20000" />
                <input type="file" name="ruta_foto_perfil">
                <input type="submit" value="Registrarme">
            </form>
        </div>
        <div>
            <h2>Iniciar sesión</h2>
            <form action="hilos.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre de usuario">
                <input type="password" name="password" placeholder="Contraseña">
                <input type="submit" value="Iniciar sesión">
            </form>
        </div>

    <?php
    }
    ?>
</body>

</html>