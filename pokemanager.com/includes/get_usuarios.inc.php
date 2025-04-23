<?php
try {
    require_once 'conectar_db.inc.php';

    $texto_consulta = "SELECT * FROM usuarios ";
    $consulta = $pdo->prepare($texto_consulta);
    $consulta->execute();
    $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
    

} catch (PDOException $e) {
    echo "¡Error!: " . $e->getMessage();
}
?>