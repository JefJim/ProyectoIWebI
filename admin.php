<?php
session_start();

// Verifica si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
    header('Location: /access_denied.php');
    exit();
}

// usé esta ruta absoluta porque habían problemas con la búsqueda de process.php
$processPath = $_SERVER['DOCUMENT_ROOT'] . '/actions/process.php';

// Verifica si el archivo existe y muestra la ruta
if (file_exists($processPath)) {
    include($processPath);
} else {
    echo "Error: No se pudo encontrar el archivo process.php en $processPath.";
}

// Establecer valores predeterminados si las variables no están definidas
$totalAmigos = isset($resultAmigos['total_amigos']) ? $resultAmigos['total_amigos'] : 0;
$arbolesDisponibles = isset($resultDisponibles['arboles_disponibles']) ? $resultDisponibles['arboles_disponibles'] : 0;
$arbolesVendidos = isset($resultVendidos['arboles_vendidos']) ? $resultVendidos['arboles_vendidos'] : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Panel de Dashboard</h1>

<div class="container">
    <!-- Tarjeta de Amigos Registrados -->
    <div class="card">
        <h2>Amigos Registrados</h2>
        <p><?php echo $totalAmigos; ?></p>
    </div>

    <!-- Tarjeta de Árboles Disponibles -->
    <div class="card">
        <h2>Árboles Disponibles</h2>
        <p><?php echo $arbolesDisponibles; ?></p>
    </div>

    <!-- Tarjeta de Árboles Vendidos -->
    <div class="card">
        <h2>Árboles Vendidos</h2>
        <p><?php echo $arbolesVendidos; ?></p>
    </div>
</div>

<!-- Botones de navegación para CRUD -->
<div style="text-align: center; margin-top: 20px;">
    <button onclick="window.location.href='arboles_CRUD.php'">Administrar Árboles</button>
    <button onclick="window.location.href='CRUD_especies.php'">Administrar Especies</button>
    <button onclick="window.location.href='CRUD_amigos.php'">Administrar Amigos</button>
    <button onclick="window.location.href='actions/logout.php'">Cerrar Sesión</button>
</div>

</body>
</html>
