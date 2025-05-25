<?php
if (isset($_SESSION['pokemons_usuario']) && count(array_unique($_SESSION['pokemons_usuario'])) < 6) {
    echo "<p>No tienes suficientes Pokémon para combatir.</p>";
} else {
    require_once 'includes/get_usuarios.inc.php';
    include_once 'includes/get_pokemons.inc.php';

    $usuariosValidos = array_filter($usuarios, function ($usuario) use ($pdo) {
        if ($usuario['id'] == $_SESSION['user_info']['id']) return false;

        $pokemons = getUserPokemons($usuario['id'], $pdo);
        $pokemonUnicos = array_unique(array_column($pokemons, 'id_pokemon'));

        return count($pokemonUnicos) >= 6;
    });

    if (empty($usuariosValidos)) {
        die("No hay usuarios válidos con al menos 6 Pokémon únicos.");
    }

    $randomUsuario = $usuariosValidos[array_rand($usuariosValidos)];
    $usuarioAleatorioId = $randomUsuario['id'];
    $pokemonRivalTodos = getUserPokemons($usuarioAleatorioId, $pdo);

    // Selección de Pokémon rival
    $pokemonRivalTodos = getUserPokemons($usuarioAleatorioId, $pdo);
    $pokemonRivalIds = array_column($pokemonRivalTodos, 'id_pokemon');
    shuffle($pokemonRivalIds);
    $pokemonsRival = array_slice($pokemonRivalIds, 0, 6);

    // Selección de Pokémon del usuario
    $userPokemonIds = $_SESSION['pokemons_usuario'];
    shuffle($userPokemonIds);
    $pokemonsUsuario = array_slice($userPokemonIds, 0, 6);

    // Crear lookup de Pokémon
    $pokemonById = [];
    foreach ($pokedex as $p) {
        $pokemonById[$p['id']] = $p;
    }
?>


    <div class='combate-pokemons-container'>

        <div class='combate-pokemons-usuario-container'>
            <h2>Equipo de <?= htmlspecialchars($_SESSION['user_info']['nombre']) ?></h2>
            <div class='combate-pokemons-usuario'>
                <?php foreach ($pokemonsUsuario as $pokemonId):
                    $pokemon = $pokemonById[$pokemonId] ?? null;
                    if ($pokemon): ?>
                        <div class='pokemon-card'
                            data-id='<?= $pokemon['id'] ?>'
                            data-name='<?= $pokemon['Name'] ?>'
                            data-type1='<?= $pokemon['Type 1'] ?>'
                            data-type2='<?= $pokemon['Type 2'] ?>'
                            data-iconpath='<?= $pokemon['icon_path'] ?>'
                            data-hp='<?= $pokemon['HP'] ?>'
                            data-attack='<?= $pokemon['Attack'] ?>'
                            data-defense='<?= $pokemon['Defense'] ?>'
                            data-specialattack='<?= $pokemon['Sp. Atk'] ?>'
                            data-specialdefense='<?= $pokemon['Sp. Def'] ?>'
                            data-speed='<?= $pokemon['Speed'] ?>'
                            data-description='<?= htmlspecialchars($pokemon['Description']) ?>'>
                            <img class='pokemon-img' src='<?= $pokemon['icon_path'] ?>' alt='<?= htmlspecialchars($pokemon['Name']) ?>'>
                            <h3 class='pokemon-nombre'><?= htmlspecialchars($pokemon['Name']) ?></h3>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <button id="start-battle">¡Combatir!</button>
        </div>

        <div class='combate-pokemons-rival-container'>
            <h2>Equipo de <?= htmlspecialchars($randomUsuario['nombre']) ?></h2>
            <div class='combate-pokemons-rival'>
                <?php foreach ($pokemonsRival as $pokemonId):
                    $pokemon = $pokemonById[$pokemonId] ?? null;
                    if ($pokemon): ?>
                        <div class='pokemon-card'
                            data-id='<?= $pokemon['id'] ?>'
                            data-name='<?= $pokemon['Name'] ?>'
                            data-type1='<?= $pokemon['Type 1'] ?>'
                            data-type2='<?= $pokemon['Type 2'] ?>'
                            data-iconpath='<?= $pokemon['icon_path'] ?>'
                            data-hp='<?= $pokemon['HP'] ?>'
                            data-attack='<?= $pokemon['Attack'] ?>'
                            data-defense='<?= $pokemon['Defense'] ?>'
                            data-specialattack='<?= $pokemon['Sp. Atk'] ?>'
                            data-specialdefense='<?= $pokemon['Sp. Def'] ?>'
                            data-speed='<?= $pokemon['Speed'] ?>'
                            data-description='<?= htmlspecialchars($pokemon['Description']) ?>'>
                            <img class='pokemon-img' src='<?= $pokemon['icon_path'] ?>' alt='<?= htmlspecialchars($pokemon['Name']) ?>'>
                            <h3 class='pokemon-nombre'><?= htmlspecialchars($pokemon['Name']) ?></h3>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>





    

<?php } ?>