<?php
$nombreDB = 'LM';
$rutaDB = 'localhost';
$usuarioDB = 'root';
$contrasenaDB = '';

try {
    $pdo = new PDO("mysql:host=$rutaDB;dbname=$nombreDB", $usuarioDB, $contrasenaDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
    echo "nice";
} catch (PDOException $e) {
    die("¡Error!: " . $e->getMessage() . "<br/>");
}
