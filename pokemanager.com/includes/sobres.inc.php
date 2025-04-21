<?php
    echo "<div class='sobres-contenedor'>";
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

