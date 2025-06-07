<?php
include_once 'includes/header.inc.php';
?>

<div class="info">
    <h1>¡Ha habido un error!</h1>
    <?php
    if (isset($_SESSION['error'])) {
    ?>
        <div class="error">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
            <img src="img/sad_pikachu.jpg" alt="Pikachu triste" class="error-image">
        </div>
    <?php
    }

    ?>
    
</div>

<?php
include_once 'includes/footer.inc.php';
?>