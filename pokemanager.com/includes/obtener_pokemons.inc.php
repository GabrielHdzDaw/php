<?php
require_once 'includes/conectar_db.inc.php';

function obtenerPokemons($conexion, $offset, $limit) {
    // Prepara la consulta SQL
    $sql = "SELECT * FROM pokemons LIMIT :offset, :limit";
    $stmt = $conexion->prepare($sql);
    
    // Asigna los valores a los parámetros
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    
    // Ejecuta la consulta
    $stmt->execute();
    
    // Obtiene los resultados
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}   

$pokemons = obtenerPokemons($conexion, $_GET['offset'], $_GET['limit']);
if ($pokemons) {
    // Si se obtuvieron resultados, los devolvemos como JSON
    echo json_encode($pokemons);
} else {
    // Si no se encontraron resultados, devolvemos un mensaje de error
    echo json_encode(['error' => 'No se encontraron pokémons.']);
}
?>