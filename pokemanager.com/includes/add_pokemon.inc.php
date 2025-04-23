<?php
if (isset($_SESSION['pokemons'])) {
    try {
        require_once 'conectar_db.inc.php';

        $texto_consulta = "INSERT INTO tiene (id_usuario, id_pokemon) VALUES (:id_usuario, :id_pokemon)";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(':id_usuario', $_SESSION['user_info']['id']);
        foreach ($_SESSION['pokemons'] as $pokemon) {
            $consulta->bindParam(':id_pokemon', $pokemon['id']);
            $consulta->execute();
        }
        
    } catch (PDOException $e) {
        echo "¡Error!: " . $e->getMessage();
    }
}
