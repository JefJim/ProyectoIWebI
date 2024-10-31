<?php
require($_SERVER['DOCUMENT_ROOT'] . '/utils/functions.php');

// get the connection
$conexion = getConnection();

// check the connection
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// SQL queries to count friends, available trees and sold trees
$sqlfriends = "SELECT COUNT(*) AS total_friends FROM users WHERE isAdmin = 0"; // Count only friends
$sqlDisponibles = "SELECT COUNT(*) AS trees_disponibles FROM trees WHERE status = 0"; // count available trees
$sqlVendidos = "SELECT COUNT(*) AS trees_vendidos FROM trees WHERE status = 1"; // count sold trees

// Execute the query to count friends
$resultfriends = $conexion->query($sqlfriends);
if ($resultfriends) {
    $resultfriends = $resultfriends->fetch_assoc(); // Get result as associative array
 

} else {
    // Error counting friends
    error_log("Error in friends query: " . $conexion->error);
}

// Execute the query to count available trees
$resultDisponibles = $conexion->query($sqlDisponibles);
if ($resultDisponibles) {
    $resultDisponibles = $resultDisponibles->fetch_assoc();
} else {
    // Error counting available trees
    error_log("Error querying available trees: " . $conexion->error);
}

// Execute the query to count sold trees
$resultVendidos = $conexion->query($sqlVendidos);
if ($resultVendidos) {
    $resultVendidos = $resultVendidos->fetch_assoc();
} else {
    // Error counting sold trees
    error_log("Error in query of trees sold: " . $conexion->error);
}

// Close the connection
$conexion->close();
?>
