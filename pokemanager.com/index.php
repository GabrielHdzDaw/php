<?php
include_once 'includes/header.inc.php';
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
            <h3>Sobres</h3>
            <?php include_once 'includes/sobres.inc.php'; ?>
        </div>

        <div id="PokéDex" class="tabcontent">
            <h3>PokéDex</h3>
            <?php include_once 'includes/pokedex.inc.php'; ?>
        </div>

        <div id="Combate" class="tabcontent">
            <h3>Combate</h3>
            <?php include_once 'includes/combate.inc.php'; ?>
        </div>

        <div id="Perfil" class="tabcontent">
            <h3>Perfil</h3>
            <?php include_once 'includes/perfil.inc.php'; ?>
        </div>

        <div id="Administrador" class="tabcontent">
            <h3>Administrador</h3>
            <p>Aquí puedes administrar la página</p>
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
    <script src="scripts/dialogsSobres.js"></script>
</main>
<?php include 'includes/footer.inc.php'; ?>