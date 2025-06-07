<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sobre = $_POST['id_sobre'] ?? null;
    try {
        require_once 'get_pokemons.inc.php';
        require_once 'conectar_db.inc.php';

        $pokemons = [];
        switch ($id_sobre) {
            case 0:
                $keys = array_rand($gen_1, 5);
                $pokemons = array_map(fn($key) => $gen_1[$key], (array)$keys);
                break;
            case 1:
                $keys = array_rand($gen_2, 5);
                $pokemons = array_map(fn($key) => $gen_2[$key], (array)$keys);
                break;
            case 2:
                $keys = array_rand($gen_3, 5);
                $pokemons = array_map(fn($key) => $gen_3[$key], (array)$keys);
                break;
            case 3:
                $keys = array_rand($gen_4, 5);
                $pokemons = array_map(fn($key) => $gen_4[$key], (array)$keys);
                break;
            case 4:
                $keys = array_rand($gen_5, 5);
                $pokemons = array_map(fn($key) => $gen_5[$key], (array)$keys);
                break;
            case 5:
                $keys = array_rand($gen_6, 5);
                $pokemons = array_map(fn($key) => $gen_6[$key], (array)$keys);
                break;
            case 6:
                $keys = array_rand($legendarios, 5);
                $pokemons = array_map(fn($key) => $legendarios[$key], (array)$keys);
                break;
            default:
                break;
        }

        $_SESSION['pokemons'] = $pokemons;

        // Guardar los pokémon obtenidos en la base de datos
        $insertar = $pdo->prepare("INSERT INTO tiene (id_usuario, id_pokemon) VALUES (:id_usuario, :id_pokemon)");
        foreach ($pokemons as $pokemon) {
            $insertar->execute([
                ':id_usuario' => $_SESSION['user_info']['id'],
                ':id_pokemon' => $pokemon['id']
            ]);
        }

        // Actualizar sobres
        $sobres = $_SESSION['user_info']['sobres'] - 1;
        $_SESSION['user_info']['sobres'] = $sobres;
        $consulta_sobres = $pdo->prepare("UPDATE usuarios SET sobres = :sobres WHERE id = :id_usuario");
        $consulta_sobres->execute([
            ':sobres' => $sobres,
            ':id_usuario' => $_SESSION['user_info']['id']
        ]);

        header('Location: ../index.php');
    } catch (PDOException $e) {
        echo "¡Error!: " . $e->getMessage();
    }
}
