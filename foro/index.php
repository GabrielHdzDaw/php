<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "includes/nav.inc.php";

if (isset($_SESSION['started'])) {
    echo "<h2>Bienvenido " . "<a href='user.php'>" . $_SESSION['user_info']['nombre'] . "</a>" . "</h2>";
    echo "<a href='includes/logout.inc.php'>Cerrar sesión</a>";
} else {
    echo "<h2>Inicia sesión o regístrate</h2>";
}
?>
<section class="contenedor-formulario">
    <div>
        <form action="includes/registro.inc.php" method="POST" enctype="multipart/form-data" class="formulario-registro">
            <h2>Regístrate</h2>
            <input type="text" name="nombre" placeholder="Nombre de usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="email" name="email" placeholder="email" required>
            <label for="ruta_foto_perfil">Foto de perfil</label>

            <input type="file" name="ruta_foto_perfil" id="ruta_foto_perfil" accept="image/*">
            <input type="submit" value="Registrarme">
        </form>
    </div>
    <div>
        <form action="includes/login.inc.php" method="POST" class="formulario-login">
            <h2>Inicia sesión</h2>
            <input type="text" name="nombre" placeholder="Nombre de usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar sesión">
        </form>
    </div>
</section>
<h2>Hilos</h2>
<section class="hilos-index">


    <?php
    try {
        require_once "includes/conectar_db.inc.php";
        $texto_consulta = "
                SELECT 
                    hilos.id AS hilo_id,
                    usuarios.id AS usuario_id,
                    hilos.*, 
                    usuarios.* 
                FROM hilos 
                JOIN usuarios ON hilos.id_usuario = usuarios.id 
                ORDER BY hilos.creado DESC
                LIMIT 5";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->execute();
        $hilos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($hilos as $hilo) {
            echo "<a href='hilo.php?id=" . htmlspecialchars($hilo['hilo_id']) . "'>";
            echo "<article class='hilo-thumbnail'>";
            echo "<img src='" . htmlspecialchars($hilo['ruta_foto_hilo']) . "' alt='Foto del hilo' class='foto-hilo-thumbnail'>";
            echo "<h4>" . htmlspecialchars($hilo['creado']) . "</h4>";
            echo "<h3>" . htmlspecialchars($hilo['titulo']) . "</h3>";
            echo "<p>" . htmlspecialchars($hilo['descripcion']) . "</p>";
            echo "@" . htmlspecialchars($hilo['nombre']) . "</p>";
            echo "</article>";
            echo "</a>";
        }
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
    ?>
</section>

</body>

</html>