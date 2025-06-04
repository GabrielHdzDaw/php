<?php
session_start();
include_once "../conectar_db.inc.php";

if ($_SESSION['started'] && $_SESSION['user_info']['is_admin'] == 1) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_usuario = $_GET['id'];
        $consulta = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $consulta->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        if ($consulta->execute()) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar el usuario.";
        }
    } else {
        echo "ID de usuario no válido.";
    }
} else {
    echo "No tienes permisos para realizar esta acción.";
}
