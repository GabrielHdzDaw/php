<?php

$generaciones_data = [];

if (isset($_SESSION['started'])) {
    try {
        require_once 'conectar_db.inc.php';

        $regiones = [
            1 => 'Kanto',
            2 => 'Johto',
            3 => 'Hoenn',
            4 => 'Sinnoh',
            5 => 'Unova',
            6 => 'Kalos'
        ];

        for ($gen = 1; $gen <= 6; $gen++) {
            // Contar total de pokémon de esta generación
            $query_total = "SELECT COUNT(*) as total FROM pokemon WHERE Generation = ?";
            $stmt_total = $pdo->prepare($query_total);
            $stmt_total->execute([$gen]);
            $total = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar pokémon capturados de esta generación
            $capturados = 0;
            if (!empty($_SESSION['pokemons_usuario'])) {
                $placeholders = implode(',', array_fill(0, count($_SESSION['pokemons_usuario']), '?'));
                $query_capturados = "
                    SELECT COUNT(DISTINCT p.id) as capturados
                    FROM pokemon p
                    WHERE p.Generation = ?
                    AND p.id IN ($placeholders)
                ";
                $stmt_capturados = $pdo->prepare($query_capturados);
                // Parámetros: generación + IDs de pokémon
                $params = array_merge([$gen], $_SESSION['pokemons_usuario']);
                $stmt_capturados->execute($params);
                $capturados = $stmt_capturados->fetch(PDO::FETCH_ASSOC)['capturados'];
            }

            // Calcular porcentaje
            $porcentaje = $total > 0 ? ($capturados / $total) * 100 : 0;

            $generaciones_data[$gen] = [
                'total' => $total,
                'capturados' => $capturados,
                'porcentaje' => round($porcentaje, 2),
                'region' => $regiones[$gen] ?? "Gen $gen"
            ];
        }
    } catch (PDOException $e) {
        error_log("Error en generaciones: " . $e->getMessage());
    }
}
?>