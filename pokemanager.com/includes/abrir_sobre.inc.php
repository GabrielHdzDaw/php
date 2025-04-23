<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sobre = $_POST['id_sobre'] ?? null;
    try {
        require_once 'get_pokemons.inc.php';
        $pokemons = [];
        switch ($id_sobre) {
            case 0:
                // Generar 5 pokemons aleatorios de la gen 1
                $keys = array_rand($gen_1, 5);
                $pokemons = array_map(function ($key) use ($gen_1) {
                    return $gen_1[$key];
                }, (array)$keys);
                break;
            case 1:
                // Generar 5 pokemons aleatorios de la gen 2
                $keys = array_rand($gen_2, 5);
                $pokemons = array_map(function ($key) use ($gen_2) {
                    return $gen_2[$key];
                }, (array)$keys);
                break;
            case 2:
                // Generar 5 pokemons aleatorios de la gen 3
                $keys = array_rand($gen_3, 5);
                $pokemons = array_map(function ($key) use ($gen_3) {
                    return $gen_3[$key];
                }, (array)$keys);
                break;
            case 3:
                // Generar 5 pokemons aleatorios de la gen 4
                $keys = array_rand($gen_4, 5);
                $pokemons = array_map(function ($key) use ($gen_4) {
                    return $gen_4[$key];
                }, (array)$keys);
                break;
            case 4:
                // Generar 5 pokemons aleatorios de la gen 5
                $keys = array_rand($gen_5, 5);
                $pokemons = array_map(function ($key) use ($gen_5) {
                    return $gen_5[$key];
                }, (array)$keys);
                break;
            case 5:
                // Generar 5 pokemons aleatorios de la gen 6
                $keys = array_rand($gen_6, 5);
                $pokemons = array_map(function ($key) use ($gen_6) {
                    return $gen_6[$key];
                }, (array)$keys);
                break;
            case 6:
                // Generar 5 pokemons aleatorios legendarios
                $keys = array_rand($legendarios, 5);
                $pokemons = array_map(function ($key) use ($legendarios) {
                    return $legendarios[$key];
                }, (array)$keys);
                break;
            default:
                // die("¡Error!: Sobre no válido.");
                break;
        }
        $_SESSION['pokemons'] = $pokemons;
        $sobres = $_SESSION['user_info']['sobres'] - 1;
        $_SESSION['user_info']['sobres'] = $sobres;
        $consulta_sobres = $pdo->prepare("UPDATE usuarios SET sobres = :sobres WHERE id = :id_usuario");
        $consulta_sobres->bindParam(':sobres', $sobres, PDO::PARAM_INT);
        $consulta_sobres->bindParam(':id_usuario', $_SESSION['user_info']['id'], PDO::PARAM_INT);
        $consulta_sobres->execute();
        // var_dump($pokemons);
        header('Location: ../index.php');
    } catch (PDOException $e) {
        echo "¡Error!: " . $e->getMessage();
    }
}
