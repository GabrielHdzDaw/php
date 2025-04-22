<?php
include_once 'includes/header.inc.php';
?>
<main>
    <!-- Tab links -->
    <div class="tab">
        <button class="tablinks" data-tab="Sobres">Sobres</button>
        <button class="tablinks" data-tab="PokéDex">PokéDex</button>
        <button class="tablinks" data-tab="Combate">Combate</button>
        <button class="tablinks" data-tab="Perfil">Perfil</button>
        <button class="tablinks" data-tab="Administrador">Administrador</button>
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
        <p>Aquí puedes combatir</p>
    </div>

    <div id="Perfil" class="tabcontent">
        <h3>Perfil</h3>
        <p>Aquí puedes ver tu perfil</p>
    </div>

    <div id="Administrador" class="tabcontent">
        <h3>Administrador</h3>
        <p>Aquí puedes administrar la página</p>
    </div>

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
        unset($_SESSION['pokemons']);
        ?>
    <?php endif; ?>
</main>
<?php include_once 'includes/footer.inc.php'; ?>