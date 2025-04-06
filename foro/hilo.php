<?php
session_start();
include_once "includes/nav.inc.php";

?>



<section class="hilo-section">
    <?php

    try {
        $id_hilo = $_GET['id'];
        require_once "includes/conectar_db.inc.php";
        $texto_consulta = "
                SELECT 
                    hilos.id AS hilo_id,
                    usuarios.id AS usuario_id,
                    usuarios.nombre AS usuario_,
                    hilos.*, 
                    usuarios.* 
                FROM hilos 
                JOIN usuarios ON hilos.id_usuario = usuarios.id 
                WHERE hilos.id = :id_hilo";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->execute(['id_hilo' => $id_hilo]);
        $hilos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $comentarios_consulta = $pdo->prepare("
            SELECT 
                comentarios.texto, 
                comentarios.creado, 
                usuarios.nombre AS usuario_
            FROM comentarios 
            JOIN usuarios ON comentarios.id_usuario = usuarios.id 
            WHERE comentarios.id_hilo = :id_hilo
            ORDER BY comentarios.creado ASC
        ");
        $comentarios_consulta->execute(['id_hilo' => $id_hilo]);
        $comentarios = $comentarios_consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($hilos as $hilo) {
            echo "<article class='hilo'>";
            echo "<section class='hilo-info'>";
            echo "<h2>" . htmlspecialchars($hilo['titulo']) . " <small>por @" . htmlspecialchars($hilo['usuario_']) . "</small></h2>";
            echo "<img src='" . htmlspecialchars($hilo['ruta_foto_hilo']) . "' alt='Foto del hilo' class='foto-hilo'>";
            echo "<p>" . htmlspecialchars($hilo['descripcion']) . "</p>";
            echo "<h4>" . htmlspecialchars($hilo['creado']) . "</h4>";
            echo "</section>";
            echo "<section class='hilo-comentarios'>";
            echo "<h3>Comentarios:</h3>";
            if (empty($comentarios)) {
                echo "<p>No hay comentarios en este hilo.</p>";
            } else {
                foreach ($comentarios as $comentario) {
                    
                    echo "<div class='comentario'>";
                    echo "<a href=''><p><strong>@" . htmlspecialchars($hilo['usuario_']) . "</strong></a> dice: " . htmlspecialchars($comentario['texto']) . "</p>";
                    echo "<h4>" . htmlspecialchars($comentario['creado']) . "</h4>";
                    echo "</div>";
                }
            }

            echo "</section>";
            echo "</article>";
        }
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
    ?>
</section>



</body>

</html>