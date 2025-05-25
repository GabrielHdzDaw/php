<?php
include_once 'includes/header.inc.php';
// comprobamos la cantidad de pokemons que tiene el usuario
$pokemons_usuario = 0;
if (isset($_SESSION['started'])) {
    if (isset($_SESSION['pokemons_usuario'])) {
        $pokemons_usuario = count(array_unique($_SESSION['pokemons_usuario']));
    }
}
// comprobamos el porcentaje de pokemons que tiene el usuario
if (isset($_SESSION['pokemons_usuario'])) {
    $porcentaje = ($pokemons_usuario / 721) * 100;
} else {
    $porcentaje = 0;
}
include_once 'includes/progreso_generaciones.inc.php';
?>
<main>
    <!-- Tab links -->
    <?php
    if (isset($_SESSION['started'])) {
    ?>
        <div class="tab">
            <button class="tablinks" data-tab="Sobres">Sobres</button>
            <button class="tablinks" data-tab="PokéDex">PokéDex</button>
            <button class="tablinks" data-tab="Combate">Combate</button>
            <button class="tablinks" data-tab="Perfil">Perfil</button>
            <?php if ($_SESSION['user_info']['is_admin'] == 1) { ?>
                <button class="tablinks" data-tab="Administrador">Administrador</button>
            <?php } ?>
        </div>
        <!-- Tab content -->
        <div id="Sobres" class="tabcontent">
            <div class="info">
                <h3>¿A quién no le gusta abrir sobres?</h3>
                <p>¡Inicia sesión cada día para obtener 1 sobre! Cada vez que inicies sesión recibirás una cantidad de sobres proporcional a la cantidad de días que lleves sin conectarte.</p>
            </div>
            <?php include_once 'includes/sobres.inc.php'; ?>
        </div>

        <div id="PokéDex" class="tabcontent">
            <div class="info">
                <h3>Mi colección</h3>
                <p>¡Aquí podrás ver todos los Pokémons que has conseguido!</p>

                <!-- Contenedor principal de dos columnas -->
                <div class="dashboard-container">
                    <!-- Columna izquierda - Progreso General -->


                    <!-- Columna derecha - Progreso por Generaciones -->
                    <div class="generaciones-container">


                        <div class="datos-coleccion">
                            <div class="progress-container large">
                                <svg class="progress-circle" viewBox="0 0 100 100">
                                    <circle class="progress-bg" cx="50" cy="50" r="45" />
                                    <circle class="progress" cx="50" cy="50" r="45" />
                                </svg>
                                <div class="percentage-container">
                                    <div data-percentage="<?php echo round($porcentaje, 2); ?>" class="percentage">0%</div>
                                    <div class="pokemon-count"><?php echo $pokemons_usuario; ?>/721 capturados</div>
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
                <?php include_once 'includes/pokedex.inc.php'; ?>
            </div>
        </div>
        <div id="Combate" class="tabcontent">
            <div id="contenedor-combate-info" class="info">
                <h3>Combate</h3>
                <p>Aquí podrás enfrentar a tus pokémon con los de otros usuarios. ¡Gana y conseguirás 2 sobres!</p>
                <?php include_once 'includes/combate.inc.php'; ?>
            </div>
        </div>

        <div id="Perfil" class="tabcontent">
            <?php include_once 'includes/perfil.inc.php'; ?>
        </div>

        <div id="Administrador" class="tabcontent">
            <h3>Administrador</h3>
            <p>Aquí puedes administrar la página</p>
        </div>
    <?php
    } else {
    ?>
        <div class="info">
            <h2>¡Bienvenido a PokéManager!</h2>
            <p>¡Saludos entrenador! En PokéManager podrás crear tu colección de Pokémons y ponerlos a combatir contra los de los demás usuarios!</p>
            <p>¡Inicia sesión o regístrate para iniciar tu aventura!</p>
        </div>
    <?php
    }
    ?>

    <?php if (isset($_SESSION['pokemons'])): ?>
        <dialog id='dialogoSobre' class='dialogo-sobre'>
            <div class='dialogo-sobre-contenido'>
                <h3 class='titulo-dialogo-sobre'>Has obtenido:</h3>
                <div class='dialogo-sobre-contenido-pokemons'>
                    <?php foreach ($_SESSION['pokemons'] as $pokemon): ?>
                        <div class='pokemon-sobre-contenedor'>
                            <img class='pokemon-img' src='<?= $pokemon['icon_path'] ?>' alt='<?= $pokemon['Name'] ?>'>
                            <h3 class='pokemon-nombre'><?= $pokemon['Name'] ?></h3>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button id='cerrarDialogoSobre' class='cerrar-dialogo-sobre'>Aceptar</button>
            </div>
        </dialog>
        <?php
        include_once 'includes/add_pokemon.inc.php';
        ?>
        <?php
        unset($_SESSION['pokemons']);
        // header('Location: index.php');
        ?>

    <?php else: ?>


    <?php endif; ?>

</main>
<?php include 'includes/footer.inc.php'; ?>