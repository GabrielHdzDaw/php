<?php
try {
    require_once 'conectar_db.inc.php';
    $texto_consulta = "SELECT * FROM pokemon ORDER BY id ASC";
    $consulta = $pdo->prepare($texto_consulta);
    $consulta->execute();
    $pokedex = $consulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("¡Error!: " . $e->getMessage());
}
?>