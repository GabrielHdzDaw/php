<?php
if ($_SESSION['user_info']['sobres'] > 0) {
    echo "<div class='sobres-contenedor'>";
    echo "<h2 class='titulo-sobres'>¡Tienes " . $_SESSION['user_info']['sobres'] . " sobres!</h2>";
    echo "<div class='sobres-contenedor-grid'>";
    for ($i = 0; $i < 7; $i++) {
        echo "<div class='sobre'>";
        echo "<form action='includes/abrir_sobre.inc.php' method='POST' class='sobres-formulario'>";
        echo "<input type='hidden' name='id_sobre' value='$i'>";
        echo "<button type='submit' class='boton-imagen'>";
        echo "<img class='img-sobre' src='img/sobres/$i.png' alt='Sobre'>";
        echo "</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='info'>";
    echo "<p>¡No tienes sobres! ¡Gana combates o espera hasta mañana para poder abrir más!</p>";
    echo "</div>";
}
