<?php
require($_SERVER['DOCUMENT_ROOT'] . '/utils/functions.php');

// la conexión 
$conexion = getConnection();

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consultas SQL para contar amigos, árboles disponibles y árboles vendidos
$sqlAmigos = "SELECT COUNT(*) AS total_amigos FROM usuarios WHERE isAdmin = 0"; // Contar solo amigos
$sqlDisponibles = "SELECT COUNT(*) AS arboles_disponibles FROM arboles WHERE estado = 0"; // Contar árboles disponibles
$sqlVendidos = "SELECT COUNT(*) AS arboles_vendidos FROM arboles WHERE estado = 1"; // Contar árboles vendidos

// Ejecutar la consulta para contar amigos
$resultAmigos = $conexion->query($sqlAmigos);
if ($resultAmigos) {
    $resultAmigos = $resultAmigos->fetch_assoc(); // Obtener resultado como array asociativo
 

} else {
    // Error al contar amigos
    error_log("Error en consulta de amigos: " . $conexion->error);
}

// Ejecutar la consulta para contar árboles disponibles
$resultDisponibles = $conexion->query($sqlDisponibles);
if ($resultDisponibles) {
    $resultDisponibles = $resultDisponibles->fetch_assoc();
} else {
    // Error al contar árboles disponibles
    error_log("Error en consulta de árboles disponibles: " . $conexion->error);
}

// Ejecutar la consulta para contar árboles vendidos
$resultVendidos = $conexion->query($sqlVendidos);
if ($resultVendidos) {
    $resultVendidos = $resultVendidos->fetch_assoc();
} else {
    // Error al contar árboles vendidos
    error_log("Error en consulta de árboles vendidos: " . $conexion->error);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
