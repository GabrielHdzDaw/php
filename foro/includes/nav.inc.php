<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Chaforo</title>
</head>

<body>
    <header>
        <nav>
            <a href="index.php">
                <h1>Chaforo</h1>
            </a>
            <div>
                <ul>
                    <?php
                    if (isset($_SESSION['started'])) {
                        echo "<li><a href='user.php'>Perfil</a></li>";
                        echo "<li><a href='index.php'>Inicio</a></li>";
                        echo "<li><a href='hilo.php'>Hilos</a></li>";
                        echo "<li><a href='includes/logout.inc.php'>Cerrar sesión</a></li>";
                    }
                    ?>
                </ul>
            </div>
            
            <!-- <div>
                <button><a href="">Crear Hilo</a></button>
            </div> -->
        </nav>
    </header>