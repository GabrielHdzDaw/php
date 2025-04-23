<?php
try {
    require_once 'conectar_db.inc.php';
    $texto_consulta = "SELECT * FROM pokemon ORDER BY id ASC";
    $consulta = $pdo->prepare($texto_consulta);
    $consulta->execute();
    $pokedex = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_SESSION['started'])) {
        $texto_consulta_usuario = "SELECT t.id_pokemon FROM tiene t JOIN usuarios u ON t.id_usuario = :id_usuario";
        $consulta_usuario = $pdo->prepare($texto_consulta_usuario);
        $consulta_usuario->bindParam(':id_usuario', $_SESSION['user_info']['id'], PDO::PARAM_INT);
        $consulta_usuario->execute();
        $pokemons_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);
        unset($_SESSION['pokemons_usuario']);
        foreach ($pokemons_usuario as $pokemon) {
            $_SESSION['pokemons_usuario'][] = $pokemon['id_pokemon'];
        }
    }
} catch (PDOException $e) {
    die("¡Error!: " . $e->getMessage());
}

if ($pokedex) {
    if (isset($_SESSION['started'])) {
        echo "<div class='pokedex'>";
        foreach ($pokedex as $pokemon) {
            $nombrePokemon = "?";
            // Verifica si el ID del Pokémon está en la sesión del usuario
            if (isset($_SESSION['pokemons_usuario'])) {
                $notFoundClass = (in_array($pokemon['id'], $_SESSION['pokemons_usuario']))
                    ? ''
                    : 'pokemon-not-found';
                $nombrePokemon = (in_array($pokemon['id'], $_SESSION['pokemons_usuario'])) ? $pokemon['Name'] : "?";
            } else {
                $notFoundClass = 'pokemon-not-found';
            }
            echo "<div class='pokemon-card' 
                    data-id='" . $pokemon['id'] . "'
                    data-name='" . $pokemon['Name'] . "'
                    data-type1='" . $pokemon['Type 1'] . "'
                    data-type2='" . $pokemon['Type 2'] . "'
                    data-legendary='" . $pokemon['Legendary'] . "'
                    data-icon='" . $pokemon['icon_path'] . "'
                    data-hp='" . $pokemon['HP'] . "'
                    data-attack='" . $pokemon['Attack'] . "'
                    data-defense='" . $pokemon['Defense'] . "'
                    data-specialattack='" . $pokemon['Sp. Atk'] . "'
                    data-specialdefense='" . $pokemon['Sp. Def'] . "'
                    data-speed='" . $pokemon['Speed'] . "'
                    data-total='" . $pokemon['Total'] . "'
                    data-generation='" . $pokemon['Generation'] . "'
                    data-description='" . $pokemon['Description'] . "'>";
            echo "<img class='pokemon-img $notFoundClass' src='" . $pokemon['icon_path'] . "' alt='" . $nombrePokemon . "'>";
            echo "<h3 class='pokemon-nombre'>" . $nombrePokemon . "</h3>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>Inicia sesión para ver tu PokéDex.</p>";
    }
} else {
    echo "<p>No se encontraron Pokémon en la PokéDex.</p>";
}
?>

<dialog id="pokedexDialog" class="pokedex-dialog">
    <div class="pokedex-dialog-content">
        <button id="closePokedexDialog" class="close-button">Cerrar</button>
        <h2></h2>
        <img class="img-pokemon" src="" alt="">
        <p></p>
    </div>
</dialog>