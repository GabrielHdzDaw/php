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

$pokemons_usuario = 0;
if (isset($_SESSION['started'])) {
    if (isset($_SESSION['pokemons_usuario'])) {
        $pokemons_usuario = count(array_unique($_SESSION['pokemons_usuario']));
    }
}

if (isset($_SESSION['pokemons_usuario'])) {
    $porcentaje = ($pokemons_usuario / 721) * 100;
} else {
    $porcentaje = 0;
}

include_once 'includes/progreso_generaciones.inc.php';
?>



<a class="a-volver-arriba" href="#"><button class="volver-arriba">Volver arriba</button></a>
<div class="dashboard-container">
    <div class="generaciones-container">
        <div class="datos-coleccion">
            <div class="progress-container large">
                <svg class="progress-circle" viewBox="0 0 100 100">
                    <circle class="progress-bg" cx="50" cy="50" r="45" />
                    <circle class="progress" cx="50" cy="50" r="45" />
                </svg>
                <div class="percentage-container">
                    <div data-percentage="<?php echo round($porcentaje, 2); ?>" class="percentage">0%</div>
                    <div class="pokemon-count"><?php echo $pokemons_usuario; ?>/721 Pokémon capturados</div>
                </div>
            </div>
        </div>

        <div class="generaciones-grid">
            <?php foreach ($generaciones_data as $gen => $data): ?>
                <div class="generacion-item" data-gen="<?php echo $gen; ?>">
                    <div class="generacion-header">
                        <div>
                            <h4 class="generacion-nombre">
                                Generación <?php echo $gen; ?>
                                <span class="region-badge"><?php echo $data['region']; ?></span>
                            </h4>
                            <div class="generacion-stats">
                                <span class="pokemon-capturados">0</span>/<span class="pokemon-total"><?php echo $data['total']; ?></span> Pokémon capturados
                            </div>
                        </div>
                        <div class="circular-progress">
                            <svg viewBox="0 0 36 36">
                                <circle class="circular-bg" cx="18" cy="18" r="16" />
                                <circle class="circular-progress-bar" cx="18" cy="18" r="16" />
                            </svg>
                            <div class="circular-text">0%</div>
                        </div>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" data-percentage="<?php echo round($data['porcentaje'], 2); ?>" data-capturados="<?php echo $data['capturados']; ?>"></div>
                        <div class="progress-text">0%</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



<?php
if ($pokedex) {
    if (isset($_SESSION['started'])) {
        echo "<div class='pokedex'>";
        foreach ($pokedex as $pokemon) {
            $nombrePokemon = "?";

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