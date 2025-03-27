<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora</title>
</head>

<body>
    <div>
        <?php
        session_start();
        $error = $_SESSION['error'] ?? 'Error desconocido'; // Podemos usar el operador de fusión de null para asignar un valor por defecto
        unset($_SESSION['error']);
        echo "<p class='error'>Error: $error</p>";
        ?>
        <a href="index.php">Volver</a>
    </div>

</body>

</html>