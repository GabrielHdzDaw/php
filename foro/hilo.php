<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "includes/nav.inc.php";

?>



<section class="hilo-section">
    <?php

    try {
        if (!isset($_SESSION['started'])) {
            echo "<p>Debes iniciar sesión para ver los hilos.</p>";
            exit;
        } else {
            if (!isset($_GET['id'])) {
                echo "<p>El ID del hilo no está definido.</p>";
                exit;
            } else {
                $id_hilo = $_GET['id'];
            }

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
            $hilo = $consulta->fetch(PDO::FETCH_ASSOC);

            $comentarios_consulta = $pdo->prepare("
                SELECT 
                    comentarios.texto, 
                    comentarios.creado, 
                    usuarios.nombre AS usuario_,
                    usuarios.ruta_foto_perfil AS foto_perfil
                    
                FROM comentarios 
                JOIN usuarios ON comentarios.id_usuario = usuarios.id 
                WHERE comentarios.id_hilo = :id_hilo
                ORDER BY comentarios.creado ASC
            ");
            $comentarios_consulta->execute(['id_hilo' => $id_hilo]);
            $comentarios = $comentarios_consulta->fetchAll(PDO::FETCH_ASSOC);


            if (!$hilo) {
                echo "<p>El hilo no existe o ha sido eliminado.</p>";
                exit;
            } else {
                echo "<article class='hilo'>";
                echo "<section class='hilo-info'>";
                echo "<h2>" . htmlspecialchars($hilo['titulo']) . " <small>por <a href=''@" . htmlspecialchars($hilo['usuario_']) . "</a>" . "</small></h2>";
                echo "<img src='" . htmlspecialchars($hilo['ruta_foto_hilo']) . "' alt='Foto del hilo' class='foto-hilo'>";
                echo "<p>" . htmlspecialchars($hilo['descripcion']) . "</p>";
                echo "<h4>" . htmlspecialchars($hilo['creado']) . "</h4>";
                echo "</section>";
                echo "<section class='hilo-comentarios'>";
    ?>
                <form action="" method="POST" class="formulario-comentario">
                    <textarea name="comentario" id="comentario" cols="70" rows="5" placeholder="Escribe tu comentario aquí..."></textarea>
                    <input type="submit" value="Enviar comentario">
                </form>
                <h3>Comentarios:</h3>
    <?php
                if (empty($comentarios)) {
                    echo "<p>No hay comentarios en este hilo.</p>";
                } else {
                    foreach ($comentarios as $comentario) {
                        echo "<div class='comentario'>";
                        echo "<a href=''><img src='" . htmlspecialchars($comentario['foto_perfil']) . "' alt='Foto del usuario' class='foto-perfil-comentario'></a>";
                        echo "<a href=''><p><strong>@" . htmlspecialchars($comentario['usuario_']) . "</strong></a> dice: " . htmlspecialchars($comentario['texto']) . "</p>";
                        echo "<h4>" . htmlspecialchars($comentario['creado']) . "</h4>";
                        echo "</div>";
                    }
                }

                echo "</section>";
                echo "</article>";
            }
        }
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
    ?>
</section>



</body>

</html>