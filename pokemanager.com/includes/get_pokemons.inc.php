<?php
try {
    require_once 'conectar_db.inc.php';
    $texto_consulta_todos = "SELECT * FROM pokemon ORDER BY id ASC";
    $consulta = $pdo->prepare($texto_consulta_todos);
    $consulta->execute();
    $pokedex = $consulta->fetchAll(PDO::FETCH_ASSOC);

    //gen 1
    $texto_consulta_gen_1 = "SELECT * FROM pokemon WHERE Generation = 1 ORDER BY id ASC";
    $consulta_gen_1 = $pdo->prepare($texto_consulta_gen_1);
    $consulta_gen_1->execute();
    $gen_1 = $consulta_gen_1->fetchAll(PDO::FETCH_ASSOC);

    //gen 2
    $texto_consulta_gen_2 = "SELECT * FROM pokemon WHERE Generation = 2 ORDER BY id ASC";
    $consulta_gen_2 = $pdo->prepare($texto_consulta_gen_2);
    $consulta_gen_2->execute();
    $gen_2 = $consulta_gen_2->fetchAll(PDO::FETCH_ASSOC);

    //gen 3
    $texto_consulta_gen_3 = "SELECT * FROM pokemon WHERE Generation = 3 ORDER BY id ASC";
    $consulta_gen_3 = $pdo->prepare($texto_consulta_gen_3);
    $consulta_gen_3->execute();
    $gen_3 = $consulta_gen_3->fetchAll(PDO::FETCH_ASSOC);

    //gen 4
    $texto_consulta_gen_4 = "SELECT * FROM pokemon WHERE Generation = 4 ORDER BY id ASC";
    $consulta_gen_4 = $pdo->prepare($texto_consulta_gen_4);
    $consulta_gen_4->execute();
    $gen_4 = $consulta_gen_4->fetchAll(PDO::FETCH_ASSOC);

    //gen 5
    $texto_consulta_gen_5 = "SELECT * FROM pokemon WHERE Generation = 5 ORDER BY id ASC";
    $consulta_gen_5 = $pdo->prepare($texto_consulta_gen_5);
    $consulta_gen_5->execute();
    $gen_5 = $consulta_gen_5->fetchAll(PDO::FETCH_ASSOC);

    //gen 6
    $texto_consulta_gen_6 = "SELECT * FROM pokemon WHERE Generation = 6 ORDER BY id ASC";
    $consulta_gen_6 = $pdo->prepare($texto_consulta_gen_6);
    $consulta_gen_6->execute();
    $gen_6 = $consulta_gen_6->fetchAll(PDO::FETCH_ASSOC);

    // Consulta pokemon legendarios
    $texto_consulta_legendarios = "SELECT * FROM pokemon WHERE Legendary = 1 ORDER BY RAND() LIMIT 1";
    $consulta_legendarios = $pdo->prepare($texto_consulta_legendarios);
    $consulta_legendarios->execute();
    $legendarios = $consulta_legendarios->fetchAll(PDO::FETCH_ASSOC);

    // Coger pokemon aleatorio de todos los pokemon
    $texto_consulta_aleatorio = "SELECT * FROM pokemon ORDER BY RAND() LIMIT 4";
    $consulta_aleatorio = $pdo->prepare($texto_consulta_aleatorio);
    $consulta_aleatorio->execute();
    $pokemons_aleatorios = $consulta_aleatorio->fetchAll(PDO::FETCH_ASSOC);

    //unimos los 4 pokemon aleatorios con un legendario
    $legendarios = array_merge($legendarios, $pokemons_aleatorios);

    $texto_consulta_usuario = "SELECT t.id_pokemon FROM tiene t JOIN usuarios u ON t.id_usuario = :id_usuario";
    $consulta_usuario = $pdo->prepare($texto_consulta_usuario);
    $consulta_usuario->bindParam(':id_usuario', $usuario['id'], PDO::PARAM_INT);
    $consulta_usuario->execute();
    $pokemons_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);

    foreach ($pokemons_usuario as $pokemon) {
        $_SESSION['pokemons_usuario'][] = $pokemon['id_pokemon'];
    }
} catch (PDOException $e) {
    echo "¡Error!: " . $e->getMessage();
}

function getUserPokemons($id, $pdo){
    $texto_consulta_usuario = "SELECT t.id_pokemon FROM tiene t JOIN usuarios u ON t.id_usuario = :id_usuario";
    $consulta_usuario = $pdo->prepare($texto_consulta_usuario);
    $consulta_usuario->bindParam(':id_usuario', $id, PDO::PARAM_INT);
    $consulta_usuario->execute();
    $pokemons_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);
    return $pokemons_usuario;
}