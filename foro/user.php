<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    require_once "includes/conectar_db.inc.php";
    $textoConsulta = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id_usuario");
    $textoConsulta->bindParam(":id_usuario", $_GET['id']);
    $textoConsulta->execute();
} catch (PDOException $e) {
    die("¡Error!: " . $e->getMessage());
}
include_once "includes/nav.inc.php";





?>

<dialog id="dialogoActualizarDatos" class="dialogo">
    <form action="" method="POST" class="formulario-actualizar-datos">
        <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña actual" required>
        <input type="password" name="nueva_contrasena" id="nueva_contrasena" placeholder="Nueva contraseña">
        <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" required>
        <input type="submit" value="Actualizar datos">
    </form>
</dialog>
<dialog id="dialogoBorrarUsuario" class="dialogo">
    <form action="" method="POST" class="formulario-borrar-usuario">
        <input type="password" name="contrasena" id="contrasena" placeholder="Introduce tu contraseña" required>
        <input type="submit" value="Borrar cuenta">
    </form>
</dialog>
<dialog id="dialogoNuevoHilo" class="dialogo">
    <form action="includes/hilo.inc.php" method="POST" class="formulario-nuevo-hilo" enctype="multipart/form-data">
        <input type="text" name="titulo" id="titulo" placeholder="Título del hilo" required>
        <textarea name="descripcion" id="descripcion" cols="70" rows="5" placeholder="Descripción del hilo" required></textarea>
        <input type="file" name="ruta_foto_hilo" id="ruta_foto_hilo" accept="image/*" required>
        <input type="submit" value="Crear hilo">
    </form>
</dialog>


<section class="section-perfil">
    <img src="<?php echo $_SESSION['user_info']['ruta_foto_perfil'] ?>" alt="Foto de perfil" class="foto-perfil-perfil">
    <h2><?php echo $_SESSION['user_info']['nombre'] ?></h2>
    <div>
        <button id="botonModificarDatos">Modificar datos</button>
        <button id="botonEliminarPerfil">Eliminar perfil</button>
        <button id="botonCrearHilo">Crear hilo</button>
    </div>
</section>
<script src="js/script.js"></script>
</body>

</html>