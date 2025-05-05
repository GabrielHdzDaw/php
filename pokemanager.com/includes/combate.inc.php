<?php
if (empty($_SESSION['pokemons_usuario'])) {
    echo "<p>No tienes suficientes Pokémon para combatir.</p>";
} else {
    require_once 'includes/get_usuarios.inc.php';

    // Ensure $usuarios is an array of user arrays with 'id'
    // Select a random user different from the current user
    do {
        $randomUsuario = $usuarios[array_rand($usuarios)];
        $usuarioAleatorioId = $randomUsuario['id'];
    } while ($usuarioAleatorioId == $_SESSION['user_info']['id']);

    include_once 'includes/get_pokemons.inc.php';

    // Fetch rival's Pokémon
    $pokemonRivalTodos = getUserPokemons($usuarioAleatorioId, $pdo);

    // Handle case where rival has no Pokémon
    while (empty($pokemonRivalTodos)) {
        $randomUsuario = $usuarios[array_rand($usuarios)];
        $usuarioAleatorioId = $randomUsuario['id'];
        $pokemonRivalTodos = getUserPokemons($usuarioAleatorioId, $pdo);
    }

    // Extract Pokémon IDs and select 6 randomly, ensuring they are unique
    $pokemonRivalIds = array_map(function ($pokemon) {
        return $pokemon['id_pokemon'];
    }, $pokemonRivalTodos);
    shuffle($pokemonRivalIds);
    $pokemonsRival = array_slice($pokemonRivalIds, 0, 6);

    // Fetch user's Pokémon from session
    if (empty($_SESSION['pokemons_usuario'])) {
        echo "No tienes Pokémon.";
    } else {
        // Select 6 random user Pokémon ensuring they are unique
        $userPokemonIds = $_SESSION['pokemons_usuario'];
        shuffle($userPokemonIds);
        $pokemonsUsuario = array_slice($userPokemonIds, 0, 6);


        // Create a lookup array for Pokémon data
        $pokemonById = [];
        foreach ($pokedex as $p) {
            $pokemonById[$p['id']] = $p;
        }
    }

    // Select 6 random user Pokémon
    $userPokemonIds = $_SESSION['pokemons_usuario'];
    shuffle($userPokemonIds);
    $pokemonsUsuario = array_slice($userPokemonIds, 0, 6);

    // Create a lookup array for Pokémon data
    $pokemonById = [];
    foreach ($pokedex as $p) {
        $pokemonById[$p['id']] = $p;
    }

    // Display Pokémon
    echo "<div class='combate-pokemons-container'>";
    echo "<div class='combate-pokemons-usuario-container'>";
    echo "<h2>Equipo de " . htmlspecialchars($_SESSION['user_info']['nombre']) . "</h2>";
    echo "<div class='combate-pokemons-usuario'>";
    foreach ($pokemonsUsuario as $pokemonId) {
        if (isset($pokemonById[$pokemonId])) {
            $pokemon = $pokemonById[$pokemonId];
            echo "<div class='pokemon-card' 
                    data-id='" . $pokemon['id'] . "'
                    data-name='" . $pokemon['Name'] . "'
                    data-type1='" . $pokemon['Type 1'] . "'
                    data-type2='" . $pokemon['Type 2'] . "'
                    data-legendary='" . $pokemon['Legendary'] . "'
                    data-iconpath='" . $pokemon['icon_path'] . "'
                    data-hp='" . $pokemon['HP'] . "'
                    data-attack='" . $pokemon['Attack'] . "'
                    data-defense='" . $pokemon['Defense'] . "'
                    data-specialattack='" . $pokemon['Sp. Atk'] . "'
                    data-specialdefense='" . $pokemon['Sp. Def'] . "'
                    data-speed='" . $pokemon['Speed'] . "'
                    data-total='" . $pokemon['Total'] . "'
                    data-generation='" . $pokemon['Generation'] . "'
                    data-description='" . $pokemon['Description'] . "'>";
            echo "<img class='pokemon-img' src='" . $pokemon['icon_path'] . "' alt='" . htmlspecialchars($pokemon['Name']) . "'>";
            echo "<h3 class='pokemon-nombre'>" . htmlspecialchars($pokemon['Name']) . "</h3>";
            echo "</div>";
        }
    }
    echo "</div>";
    echo "</div>";

    echo "<div class='combate-pokemons-rival-container'>";
    echo "<h2>Equipo de " . htmlspecialchars($randomUsuario['nombre']) . "</h2>";
    echo "<div class='combate-pokemons-rival'>";
    foreach ($pokemonsRival as $pokemonId) {
        if (isset($pokemonById[$pokemonId])) {
            $pokemon = $pokemonById[$pokemonId];
            echo "<div class='pokemon-card' 
                    data-id='" . $pokemon['id'] . "'
                    data-name='" . $pokemon['Name'] . "'
                    data-type1='" . $pokemon['Type 1'] . "'
                    data-type2='" . $pokemon['Type 2'] . "'
                    data-legendary='" . $pokemon['Legendary'] . "'
                    data-iconpath='" . $pokemon['icon_path'] . "'
                    data-hp='" . $pokemon['HP'] . "'
                    data-attack='" . $pokemon['Attack'] . "'
                    data-defense='" . $pokemon['Defense'] . "'
                    data-specialattack='" . $pokemon['Sp. Atk'] . "'
                    data-specialdefense='" . $pokemon['Sp. Def'] . "'
                    data-speed='" . $pokemon['Speed'] . "'
                    data-total='" . $pokemon['Total'] . "'
                    data-generation='" . $pokemon['Generation'] . "'
                    data-description='" . $pokemon['Description'] . "'>";
            echo "<img class='pokemon-img' src='" . $pokemon['icon_path'] . "' alt='" . htmlspecialchars($pokemon['Name']) . "'>";
            echo "<h3 class='pokemon-nombre'>" . htmlspecialchars($pokemon['Name']) . "</h3>";
            echo "</div>";
        }
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

?>

<dialog>
    <div class="combate-dialogo">
        <h2>¡Combate!</h2>
        <p>¡Has comenzado un combate contra <?= htmlspecialchars($randomUsuario['nombre_usuario']) ?>!</p>
        <div id="barraVidaJugadorContenedor">
            <div id="barraVidaJugador" class="barra-vida"></div>
        </div>
        <div id="barraVidaRivalContenedor">
            <div id="barraVidaRival" class="barra-vida"></div>
        </div>
        <button id="cerrarDialogoCombate" class="cerrar-dialogo-combate">Cerrar</button>
    </div>
</dialog>