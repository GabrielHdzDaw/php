<?php
include_once 'includes/header.inc.php';

if (!empty($_SESSION['registro_exitoso'])) {
    echo "<script>alert('Registro exitoso');</script>";
    unset($_SESSION['registro_exitoso']);
}
?>
<main>
    <!-- Tab links -->
    <?php
    if (isset($_SESSION['started'])) {
    ?>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Sobres')"
                <?php echo (!isset($_SESSION['tab']) || $_SESSION['tab'] == 'Sobres') ? 'id="defaultOpen"' : ''; ?>>
                Sobres</button>
            <button class="tablinks" onclick="openTab(event, 'Colección')"
                <?php echo (isset($_SESSION['tab']) && $_SESSION['tab'] == 'Colección') ? 'id="defaultOpen"' : ''; ?>>
                Colección</button>
            <button class="tablinks" onclick="openTab(event, 'Combate')"
                <?php echo (isset($_SESSION['tab']) && $_SESSION['tab'] == 'Combate') ? 'id="defaultOpen"' : ''; ?>>
                Combate</button>
            <button class="tablinks tabPerfil" onclick="openTab(event, 'Perfil')"
                <?php echo (isset($_SESSION['tab']) && $_SESSION['tab'] == 'Perfil') ? 'id="defaultOpen"' : ''; ?>>
                Perfil</button>
            <?php if ($_SESSION['user_info']['is_admin'] == 1) { ?>
                <button class="tablinks" onclick="openTab(event, 'Administrador')"
                    <?php echo (isset($_SESSION['tab']) && $_SESSION['tab'] == 'Administrador') ? 'id="defaultOpen"' : ''; ?>>
                    Administrador</button>
            <?php } ?>
        </div>
        <!-- Tab content -->
        <div id="Sobres" class="tabcontent">
            <div class="info">
                <h3>¿A quién no le gusta abrir sobres?</h3>
                <p>¡Inicia sesión cada día para obtener 1 sobre! Cada vez que inicies sesión recibirás una cantidad de sobres proporcional a la cantidad de días que lleves sin conectarte.</p>
                <?php include_once 'includes/sobres.inc.php'; ?>
            </div>
        </div>

        <div id="Colección" class="tabcontent">
            <div class="info">
                <h3>Mi colección</h3>
                <p>¡Aquí podrás ver todos los Pokémons que has conseguido!</p>
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
            <div class="info">
                <h3>Administrador</h3>
                <p>Aquí puedes administrar los usuarios de la página</p>
                <?php include_once 'includes/admin/admin.inc.php' ?>
            </div>

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