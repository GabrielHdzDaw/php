<?php
include_once "includes/get_usuarios.inc.php";

if ($_SESSION['started'] && $_SESSION['user_info']['is_admin'] == 1) {

    echo "<div class='admin-usuarios'>";
    foreach ($usuarios as $usuario) {
        echo "<div class='usuario'>";
        echo "<div class='contenedor-controles-usuario-admin'>";
        echo "<div class='contenedor-img-usuario-admin'>";
        echo "<img class='img-usuario-admin' src='" . $usuario['ruta_foto_perfil'] .  "' alt='Usuario' class='icono-usuario'>";
        echo "</div>";
        echo "<button data-id='" . $usuario['id'] . "'  class='btn-eliminar-usuario'>Eliminar usuario</button>";
        echo "<button class='btn-borrar-sobres'>Borrar sobres</button>";
        echo "<button class='btn-anadir-sobres'>Añadir sobres</button>";
        echo "<button class='btn-borrar-coleccion'>Borrar colección</button>";
        echo "</div>";
        echo "<div class='info-usuario-admin'>";
        echo "<span>ID: " . $usuario['id'] . "</span>";
        echo "<span>Nombre: " . $usuario['nombre'] . "</span>";
        echo "<span>Correo: " . $usuario['email'] . "</span>";
        echo "<span>Fecha de nacimiento: " . $usuario['fecha_nacimiento'] . "</span>";
        echo "<span>Fecha de registro: " . $usuario['creado'] . "</span>";
        echo "<span>Último login: " . $usuario['ultimo_login'] . "</span>";
        echo "<span>Sobres: " . $usuario['sobres'] . "</span>";
        echo "</div>";
        echo "</div>";
    }
}
