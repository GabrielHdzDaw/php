<div class="info">
    <h1>¡Ha habido un error!</h1>
    <?php
    if (isset($_GET['error'])) {
    ?>
        <div class="error">
            <?php
            echo $_GET['error'];
            ?>
        </div>
    <?php
    }

    ?>
    <img src="img/sad_pikachu.jpg" alt="Pikachu triste" class="error-image">
</div>