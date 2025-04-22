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

if ($pokedex) {
    echo "<div class='pokedex'>";
    foreach ($pokedex as $pokemon) {
        // Verifica si el ID del Pokémon está en la sesión del usuario
        $notFoundClass = (in_array($pokemon['id'], $_SESSION['pokemons_usuario']))
            ? ''
            : 'pokemon-not-found';

        echo "<div class='pokemon-card' data-id='" . $pokemon['id'] . "'>";
        echo "<img class='pokemon-img $notFoundClass' src='" . $pokemon['icon_path'] . "' alt='" . $pokemon['Name'] . "'>";
        echo "<h3 class='pokemon-nombre'>" . $pokemon['Name'] . "</h3>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No se encontraron Pokémon en la PokéDex.</p>";
}
?>

<dialog id="pokemon-dialog" class="pokemon-dialog">
    <div class="pokemon-dialog-content">
        <button id="close-dialog" class="close-button">X</button>
        <h2></h2>
        <img class="img-pokemon-modal" src="" alt="">
        <p></p>
</dialog>