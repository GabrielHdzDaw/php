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
    $data = json_decode(file_get_contents('php://input'), true);
    $isVictory = $data['victoria'] ?? false;

    // Actualizar siempre el contador de combates
    $agregarCombates = $pdo->prepare("UPDATE usuarios SET combates = combates + 1 WHERE id = :id");
    $agregarCombates->execute([':id' => $id_usuario]);
    $_SESSION['user_info']['combates'] += 1;

    // Si es una victoria, actualizar el contador de victorias
    if ($isVictory) {
        $actualizarVictorias = $pdo->prepare("UPDATE usuarios SET combates_ganados = combates_ganados + 1 WHERE id = :id");
        $actualizarVictorias->execute([':id' => $id_usuario]);

        // Inicializa el contador si no existe
        if (!isset($_SESSION['user_info']['combates_ganados'])) {
            $_SESSION['user_info']['combates_ganados'] = 0;
        }
        $_SESSION['user_info']['combates_ganados'] += 1;
    }

    echo json_encode([
        'success' => true,
        'nuevos_combates' => $_SESSION['user_info']['combates'],
        'nuevas_victorias' => $_SESSION['user_info']['combates_ganados'] ?? 0
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en base de datos: ' . $e->getMessage()]);
}
