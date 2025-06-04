<?php
include_once "../conectar_db.inc.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['is_admin'])) {
    http_response_code(400);
    echo "Datos incompletos";
    exit;
}

$id = intval($data['id']);
$is_admin = intval($data['is_admin']);

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET is_admin = :is_admin WHERE id = :id");
    $stmt->execute([':is_admin' => $is_admin, ':id' => $id]);

    echo $stmt->rowCount() > 0 ? "Rol actualizado" : "Sin cambios";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}