<?php
    include('actions/process.php');
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
            <p><?php echo $resultAmigos['total_amigos']; ?></p>
        </div>

        <!-- Tarjeta de Árboles Disponibles -->
        <div class="card">
            <h2>Árboles Disponibles</h2>
            <p><?php echo $resultDisponibles['arboles_disponibles']; ?></p>
        </div>

        <!-- Tarjeta de Árboles Vendidos -->
        <div class="card">
            <h2>Árboles Vendidos</h2>
            <p><?php echo $resultVendidos['arboles_vendidos']; ?></p>
        </div>
    </div>

    <!-- Botón de Logout -->
    <div style="text-align: center; margin-top: 20px;">
    <button onclick="window.location.href='arboles_CRUD.php'">Administrar Árboles</button>
        <button onclick="window.location.href='CRUD_especies.php'">Administrar especies</button>
        <button onclick="window.location.href='logout.php'">Administrar Amigos</button>
        <button onclick="window.location.href='logout.php'">Cerrar sesión</button>
        
    </div>
</body>
