<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Gabriel Hernández Collado">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora</title>
</head>

<body>
    <form action="index.php" method="POST">
        <input type="number" name="num1" placeholder="Introduce un número">
        <select name="operacion">
            <option value="" selected disabled>Selecciona una operación</option>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="X">X</option>
            <option value="/">/</option>
            <option value="^">Elevado</option>
            <option value="sqrt">Raíz cuadrada</option>
            <option value="!">Factorial</option>
        </select>
        <input type="number" name="num2" placeholder="Introduce un número">
        <input type="submit" value="Calcular">
    </form>
</body>
<?php


session_start();

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_VALIDATE_FLOAT);
    return $data;
}



function validate($num1, $num2, $operacion)
{
    return ($num1 !== '' && $num2 !== '' && $operacion !== '');
}

function operation($num1, $num2, $operacion)
{
    switch ($operacion) {
        case '+':
            return "$num1 + $num2 = " . ($num1 + $num2);
        case '-':
            return "$num1 - $num2 = " . ($num1 - $num2);
        case 'X':
            return "$num1 X $num2 = " . ($num1 * $num2);
        case '/':
            return ($num2 == 0) ? "No se puede dividir entre 0" : "$num1 / $num2 = " . ($num1 / $num2);
        case '^':
            return "$num1<sup>$num2</sup> = " . ($num1 ** $num2);
        case 'sqrt':
            return "&#8730;$num1 = " . sqrt($num1);
        case '!':
            return "$num1! = " . factorial($num1);

        default:
            return;
    }
}

function factorial($num)
{
    if ($num == 0) {
        return 1;
    } else {
        return $num * factorial($num - 1);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = isset($_POST['num1']) ? sanitize($_POST['num1']) : '';
    $num2 = isset($_POST['num2']) ? sanitize($_POST['num2']) : '';
    $operacion = isset($_POST['operacion']) ? $_POST['operacion'] : '';
    $result = operation($num1, $num2, $operacion);
    if ($operacion == 'sqrt' || $operacion == '!') {
        $num2 = -1;
    }
    if (!validate($num1, $num2, $operacion)) {
        $_SESSION['error'] = "Debes rellenar todos los campos";
        header('Location: error.php');
        exit();
    } elseif ($operacion == '/' && $num2 == 0) {
        $_SESSION['error'] = "No se puede dividir entre 0";
        header('Location: error.php');
        exit();
    } elseif ($operacion == 'sqrt' && $num1 < 0) {
        $_SESSION['error'] = "No se puede calcular la raíz cuadrada de un número negativo";
        header('Location: error.php');
        exit();
    } else {
        echo "<p class='result'>$result</p>";
    }
}
?>

</html>