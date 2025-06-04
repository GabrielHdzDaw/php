<?php
include_once '../conectar_db.inc.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo "Datos inválidos";
    exit;
}

$id = intval($data['id']);
$nombre = $data['nombre'];
$email = $data['email'];
$fecha_nacimiento = $data['fecha_nacimiento'];
$sobres = intval($data['sobres']);

try {
    $sql = "UPDATE usuarios 
            SET nombre = :nombre, email = :email, fecha_nacimiento = :fecha_nacimiento, sobres = :sobres 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':sobres' => $sobres,
        ':id' => $id
    ]);

    echo $stmt->rowCount() > 0 ? "Actualizado" : "Sin cambios";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error en la actualización: " . $e->getMessage();
}
