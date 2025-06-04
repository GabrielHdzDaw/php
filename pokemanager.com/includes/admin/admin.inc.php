<?php
include_once "includes/get_usuarios.inc.php";

if ($_SESSION['started'] && $_SESSION['user_info']['is_admin'] == 1) {

    
    echo "<table class='tabla-usuarios-admin'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Foto</th>";
    echo "<th>ID</th>";
    echo "<th>Es admin</th>";
    echo "<th>Nombre</th>";
    echo "<th>Correo</th>";
    echo "<th>Fecha de nacimiento</th>";
    echo "<th>Fecha de registro</th>";
    echo "<th>Último acceso</th>";
    echo "<th>Sobres</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($usuarios as $usuario) {
        $esAdmin = $usuario['is_admin'] == 1;
        $textoBtn = $esAdmin ? 'Sí' : 'No';
        $claseBtn = $esAdmin ? 'admin-si' : 'admin-no';
        echo "<tr>";
        echo "<td><img class='img-usuario-admin' src='" . $usuario['ruta_foto_perfil'] . "' alt='Usuario'></td>";
        echo "<td>" . $usuario['id'] . "</td>";
        echo "<td><button class='btn-toggle-admin $claseBtn' data-id='{$usuario['id']}' data-estado='{$usuario['is_admin']}'>$textoBtn</button></td>";
        echo "<td>" . $usuario['nombre'] . "</td>";
        echo "<td>" . $usuario['email'] . "</td>";
        echo "<td>" . $usuario['fecha_nacimiento'] . "</td>";
        echo "<td>" . $usuario['creado'] . "</td>";
        echo "<td>" . $usuario['ultimo_login'] . "</td>";
        echo "<td>" . $usuario['sobres'] . "</td>";
        
        echo "<td>";
        echo "<button data-id='" . $usuario['id'] . "' class='btn-guardar-usuario' style='display:none;'>Guardar</button> ";
        echo "<button data-id='" . $usuario['id'] . "' class='btn-cancelar-edicion' style='display:none;'>Cancelar</button>";
        echo "<button data-id='" . $usuario['id'] . "' class='btn-editar-usuario'>Editar</button> ";
        
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    
}
