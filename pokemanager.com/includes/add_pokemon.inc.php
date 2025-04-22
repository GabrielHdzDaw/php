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
        // $texto_consulta_usuario = "SELECT t.id_pokemon FROM tiene t JOIN usuarios u ON t.id_usuario = :id_usuario";
        // $consulta_usuario = $pdo->prepare($texto_consulta_usuario);
        // $consulta_usuario->bindParam(':id_usuario', $usuario['id'], PDO::PARAM_INT);
        // $consulta_usuario->execute();
        // $pokemons_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);

        // foreach ($pokemons_usuario as $pokemon) {
        //     $_SESSION['pokemons_usuario'][] = $pokemon['id_pokemon'];
        // }
    } catch (PDOException $e) {
        echo "¡Error!: " . $e->getMessage();
    }
}
