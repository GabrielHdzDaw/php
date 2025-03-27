<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB</title>
</head>

<body>
    <h1>Formulario de registro</h1>
    <form action="includes/registro.inc.php" method="POST">
        <input type="text" name="nombre_usuario" id="" placeholder="Nombre">
        <input type="password" name="contrasena" id="" placeholder="Contraseña">
        <input type="email" name="email" id="" placeholder="Correo electrónico">
        <input type="submit" value="Registrarse">
    </form>
    <?php
    if (isset($_SESSION['iniciada'])) {
    ?>
        <p>Los datos se han insertado con éxito</p>
    <?php
        unset($_SESSION["inciada"]);
    }
    ?>
</body>

</html>