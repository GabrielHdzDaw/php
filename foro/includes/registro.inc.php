<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    session_start();

    $username = $_POST['nombre'];
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $ruta_foto = 'img/default.jpg';
    
    if (is_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'])) {
        $nombreDirectorio = "img/";
        $idUnico = time();
        $nombreFichero = $idUnico . "-" . $_FILES['ruta_foto_perfil']['name'];
        move_uploaded_file($_FILES['ruta_foto_perfil']['tmp_name'], $nombreDirectorio .
            $nombreFichero);
        $rutaFoto = $nombreDirectorio . $nombreFichero;
    } else
        print("No se ha podido subir el fichero\n");


    try {
        require_once "conectar_db.inc.php";

        $texto_consulta = "INSERT INTO usuarios (nombre, email, contrasena, ruta_foto_perfil) 
                           VALUES (:nombre, :email, :contrasena, :ruta_foto)";
        $consulta = $pdo->prepare($texto_consulta);
        $consulta->bindParam(":nombre", $username);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":contrasena", $password);
        $consulta->bindParam(":ruta_foto", $ruta_foto);
    } catch (PDOException $e) {
        die("¡Error!: " . $e->getMessage());
    }
} else {
    header('Location: ../index.php');
}
