<?php
session_start();
require_once 'conectar_db.inc.php';

if (!isset($_SESSION['user_info']['id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

try {
    $id_usuario = $_SESSION['user_info']['id'];

    $agregarSobres = $pdo->prepare("UPDATE usuarios SET sobres = sobres + 2 WHERE id = :id");
    $agregarSobres->execute([':id' => $id_usuario]);

    $_SESSION['user_info']['sobres'] += 2;

    echo json_encode(['success' => true, 'nuevos_sobres' => $_SESSION['user_info']['sobres']]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en base de datos']);
}
