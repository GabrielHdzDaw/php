<?php
try {
    require_once 'conectar_db.inc.php';
    $texto_consulta = "SELECT * FROM pokemon ORDER BY id ASC";
    $consulta = $pdo->prepare($texto_consulta);
    $consulta->execute();
    $pokedex = $consulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("¡Error!: " . $e->getMessage());
}

if ($pokedex) {
    echo "<div class='pokedex'>";
    foreach ($pokedex as $pokemon) {
        echo "<div class='pokemon-card'>";
        echo "<h2 class='pokemon-card-hashtag'>#" . $pokemon['id'] . "</h2>";
        echo "<img src='" . $pokemon['icon_path'] . "' alt='" . $pokemon['Name'] . "'>";
        echo "<h3>" . $pokemon['Name'] . "</h3>";

        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No se encontraron Pokémon en la PokéDex.</p>";
}
