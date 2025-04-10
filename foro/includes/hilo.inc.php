<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
try {
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $idUsuario = $_SESSION['user_info']['id'];

        $nombreDirectorio = "../img/thread/";
        if (is_uploaded_file($_FILES['ruta_foto_hilo']['tmp_name'])) {
            $idUnico = time();
            $nombreFichero = $idUnico . "-" . $_FILES['ruta_foto_hilo']['name'];
            $rutaFoto = "img/thread/" . $nombreFichero;
            move_uploaded_file($_FILES['ruta_foto_hilo']['tmp_name'], $nombreDirectorio . $nombreFichero);
        } else
            $rutaFoto = "img/thread/" . "default_thread.jpg";
            
    }
    require_once "conectar_db.inc.php";
    $textoConsulta = $pdo->prepare("INSERT INTO hilos (titulo, descripcion, id_usuario, ruta_foto_hilo) 
                                    VALUES (:titulo, :descripcion, :id_usuario, :ruta_foto_hilo)");

    $textoConsulta->bindParam(":titulo", $titulo);
    $textoConsulta->bindParam(":descripcion", $descripcion);
    $textoConsulta->bindParam(":id_usuario", $idUsuario);
    $textoConsulta->bindParam(":ruta_foto_hilo", $rutaFoto);
    $textoConsulta->execute();
    $idHilo = $pdo->lastInsertId();
    header("Location: ../hilo.php?id=$idHilo");
} catch (PDOException $e) {
    die("¡Error!: " . $e->getMessage());
}
