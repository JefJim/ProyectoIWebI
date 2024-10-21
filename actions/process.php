<?php
require ('utils/functions.php');
$conexion = getConnection();

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consultas SQL

$sqlAmigos = "SELECT COUNT(*) AS total_amigos FROM usuarios";
$sqlDisponibles = "SELECT COUNT(*) AS arboles_disponibles FROM arboles WHERE estado = 1";
$sqlVendidos = "SELECT COUNT(*) AS arboles_vendidos FROM arboles WHERE estado = 0";

// Ejecutar consultas
$resultAmigos = $conexion->query($sqlAmigos)->fetch_assoc();
$resultDisponibles = $conexion->query($sqlDisponibles)->fetch_assoc();
$resultVendidos = $conexion->query($sqlVendidos)->fetch_assoc();






?>
