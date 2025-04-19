<?php
session_start();
include_once 'includes/header.inc.php';
?>
<main>
    <!-- Tab links -->
    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'Sobres')">Sobres</button>
        <button class="tablinks" onclick="openCity(event, 'PokéDex')">PokéDex</button>
        <button class="tablinks" onclick="openCity(event, 'Combate')">Combate</button>
        <button class="tablinks" onclick="openCity(event, 'Perfil')">Perfil</button>
        <button class="tablinks" onclick="openCity(event, 'Administrador')">Adminstrador</button>

    </div>

    <!-- Tab content -->
    <div id="Sobres" class="tabcontent">
        <h3>Sobres</h3>
        <p>Aquí puedes abrir sobres</p>
    </div>

    <div id="PokéDex" class="tabcontent">
        <h3>PokéDex</h3>
        <?php
        include_once 'includes/pokedex.inc.php';
        ?>
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
        <h3>Adminstrador</h3>
        <p>Aquí puedes administrar la página</p>
    </div>
</main>
<?php
include_once 'includes/footer.inc.php';
?>