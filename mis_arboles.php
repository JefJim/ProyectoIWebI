<?php
session_start();
require('utils/functions.php');

// Verifica si el usuario ha iniciado sesión y si no es administrador
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 1) {
    header('Location: /access_denied.php');
    exit();
}

// Obtener el ID del usuario amigo actual
$user_id = $_SESSION['user']['id'];

// Conexión a la base de datos
$conn = getConnection();

// Consulta para obtener los árboles comprados por el usuario actual
$sql = "SELECT arboles.*, especies.nombre_comercial 
        FROM arboles 
        JOIN especies ON arboles.especie = especies.id 
        WHERE arboles.userId = ? AND arboles.estado = 1"; // Árboles comprados por el usuario
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Árboles</title>
</head>

<body>

    <h1>Mis Árboles Comprados</h1>

    <table border="1">
        <tr>
            <th>Especie</th>
            <th>Ubicación</th>
            <th>Tamaño</th>
            <th>Precio</th>
            <th>Foto</th>
        </tr>

        <?php
        // Mostrar la lista de árboles comprados por el usuario
        if ($result->num_rows > 0) {
            while ($arbol = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$arbol['nombre_comercial']}</td>
                        <td>{$arbol['ubicacion']}</td>
                        <td>{$arbol['size']}</td>
                        <td>{$arbol['precio']}</td>
                        <td><img src='actions/files/{$arbol['foto']}' width='100'></td>
                      </tr>";
            }
        } 
        // Si el usuario no ha comprado árboles, mostrar un mensaje
        else {
            echo "<tr><td colspan='5'>No has comprado ningún árbol.</td></tr>";
        }
        ?>

    </table>

</body>

</html>
