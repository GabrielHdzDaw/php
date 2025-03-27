<?php $titulo = "Titulaso"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
</head>
<body>
    <section>
        <p>Texto</p>
        <?php
            echo "<p>Este texto es PHP"; ?>
    </section>
    <section>
        <?php
        $nombre = "Gabriel";
            if (true) {
                echo $nombre;
            }
        ?>
    </section>
    <section>
        <?php if ($nombre) { 
                echo "<p>Textoso {$nombre}</p>";
            } 
            ?>
    </section>

    <section>
        <?php
            $array = ["Hola", "mundo", "qué", "tal"];
            foreach ($array as $word => $value) {
                echo "{$value} ";
            }
            echo "<br>";
            for ($i=0; $i < count($array); $i++) { 
                echo"{$array[$i]} ";
            }
        ?>
    </section>

    <section>
        <?php
            
            echo "<p>{$_SERVER['DOCUMENT_ROOT']}</p>";
            echo "<p>{$_SERVER['PHP_SELF']}</p>";
            echo "<p>{$_SERVER['SERVER_NAME']}</p>";
            echo "<p>{$_SERVER['REQUEST_METHOD']}</p>";
            
            echo "<p>{$_GET['nombre']}</p>";
            echo "<p>{$_POST['nombre']}</p>"; // necesita formulario
            echo "<p>{$_FILES['nombre']}</p>"; 
            echo "<p>{$_COOKIE['nombre']}</p>"; 
            echo "<p>{$_SESSION['nombre']}</p>"; 
            echo "<p>{$_GLOBALS['nombre']}</p>"; 
        ?>
    </section>
</body>
</html>
