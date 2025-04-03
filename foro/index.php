<?php
session_start();
include_once "includes/nav.inc.php";
?>


<h1>Foro</h1>

<?php
if (isset($_SESSION['started'])) {
    echo "<h2>Bienvenido " . $_SESSION['user_info']['nombre'] . "</h2>";
    echo "<a href='includes/logout.inc.php'>Cerrar sesión</a>";
} else {
    echo "<h2>Inicia sesión o regístrate</h2>";
}
?>
<div>
    <h2>Registro</h2>
    <form action="includes/registro.inc.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre de usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <input type="email" name="email" placeholder="email" required>
        <label for="ruta_foto_perfil">Foto de perfil</label>
        
        <input type="file" name="ruta_foto_perfil" id="ruta_foto_perfil">
        <input type="submit" value="Registrarme">
    </form>
</div>
<div>
    <h2>Iniciar sesión</h2>
    <form action="includes/login.inc.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre de sexuser">
        <input type="password" name="contrasena" placeholder="Contraseña">
        <input type="submit" value="Iniciar sesión">
    </form>
</div>
</body>

</html>