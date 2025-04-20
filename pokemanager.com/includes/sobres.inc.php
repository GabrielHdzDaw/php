<?php
include_once "get_pokemons.inc.php";

if ($pokedex) {
    
    $sobres = array(array_rand($pokedex, 5), array_rand($pokedex, 5), array_rand($pokedex, 5), array_rand($pokedex, 5), array_rand($pokedex, 5));
    echo "<div class='sobres-contenedor'>";
    foreach ($sobres as $sobre) {
        echo "<div class='sobre'>";
        echo "<img class='sobre-img' src='img/sobre.png' alt='Sobre'>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No se encontraron Pokémon.</p>";
}
?>