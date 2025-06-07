<?php
session_start();
ob_start();

require_once 'conectar_db.inc.php';

$userId = $_SESSION['user_info']['id'] ?? null;
if (!$userId) {
    http_response_code(401);
    ob_end_clean();
    exit;
}

try {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $foto = $_FILES['ruta_foto_perfil'] ?? null;

    $updates = [];
    $params = [];

    if ($nombre !== null && $nombre !== $_SESSION['user_info']['nombre']) {
        if ($nombre === '') {
            http_response_code(422);
            ob_end_clean();
            exit;
        }
        $updates[] = 'nombre = ?';
        $params[] = $nombre;
    }

    if ($email !== null && $email !== $_SESSION['user_info']['email']) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(422);
            ob_end_clean();
            exit;
        }
        $updates[] = 'email = ?';
        $params[] = $email;
    }

    $rutaFoto = null;
    if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($foto['type'], $tiposPermitidos)) {
            http_response_code(415);
            ob_end_clean();
            exit;
        }

        $nombreDirectorio = '../img/profile/';
        $extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $nombreFichero = time() . '.' . strtolower($extension);
        $rutaFoto = 'img/profile/' . $nombreFichero;

        if (!move_uploaded_file($foto['tmp_name'], $nombreDirectorio . $nombreFichero)) {
            http_response_code(500);
            ob_end_clean();
            exit;
        }

        $actual = $_SESSION['user_info']['ruta_foto_perfil'] ?? '';
        if ($actual !== 'img/profile/profile_placeholder.png' && file_exists('../' . $actual)) {
            @unlink('../' . $actual);
        }

        $updates[] = 'ruta_foto_perfil = ?';
        $params[] = $rutaFoto;
    }

    if (!empty($updates)) {
        $sql = 'UPDATE usuarios SET ' . implode(', ', $updates) . ' WHERE id = ?';
        $params[] = $userId;

        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute($params)) {
            http_response_code(500);
            ob_end_clean();
            exit;
        }

        if ($nombre !== null) $_SESSION['user_info']['nombre'] = $nombre;
        if ($email !== null) $_SESSION['user_info']['email'] = $email;
        if ($rutaFoto !== null) $_SESSION['user_info']['ruta_foto_perfil'] = $rutaFoto;

        http_response_code(204);
    } else {
        http_response_code(400);
    }
} catch (Throwable $e) {
    http_response_code(500);
}

ob_end_clean();
exit;
