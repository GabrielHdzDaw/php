<div class="perfil-contenedor">
    <h2 class="titulo-perfil"><?php echo $_SESSION['user_info']['nombre']; ?></h2>
    <div class="perfil-imagen">
        <img class="img-perfil" src="<?php echo $_SESSION['user_info']['ruta_foto_perfil']; ?>" alt="Imagen de perfil">
    </div>
    <div class="perfil-info">
        <p><strong>Email:</strong> <?php echo $_SESSION['user_info']['email']; ?></p>
        <p><strong>Miembro desde:</strong> <?php echo $_SESSION['user_info']['creado']; ?></p>
        <p><strong>Combates: </strong> <?php echo ""; ?></p>
        <p><strong>Ratio de victorias: </strong> <?php echo ""; ?></p>
        <p><strong>Pokémons favoritos: </strong> <?php echo ""; ?></p>

    </div>
</div>