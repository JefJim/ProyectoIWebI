<?php
require('../utils/functions.php');
session_start();

// Verificación de sesión: el usuario debe estar autenticado y ser un amigo
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 1) {
    header('Location: /access_denied.php');
    exit();
}

// Obtener el ID del árbol
$arbol_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user']['id']; // ID del usuario amigo actual

// Verificar si se proporcionó el ID del árbol
if (!$arbol_id) {
    die("ID del árbol no proporcionado.");
}

$conn = getConnection(); // Conectar a la base de datos

// Verificar si el árbol está disponible para la compra
$sql = "SELECT * FROM arboles WHERE id = ? AND estado = 0"; //  0 "disponible"
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $arbol_id);
$stmt->execute();
$result = $stmt->get_result();
$arbol = $result->fetch_assoc();

// Verificar  existe y está disponible
if (!$arbol) {
    die("El árbol no está disponible para la compra.");
}

// Actualizar el estado del árbol a 'Vendido' (estado = 1) y asociarlo al usuario
$sql = "UPDATE arboles SET estado = 1, userId = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $arbol_id);

// Ejecutar la actualización y redirigir al usuario con un mensaje de éxito
if ($stmt->execute()) {
    header('Location: /users.php?mensaje=compra_exitosa');
    exit();
}

$conn->close(); // Cerrar la conexión a la base de datos
?>
