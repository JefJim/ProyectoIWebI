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
<html lang="es" class="h-full bg-green-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Mis Árboles</title>
</head>

<body class="h-full">
    <div class="min-h-full flex flex-col items-center py-8">
        <h1 class="text-3xl font-bold text-green-900 mb-6">Mis Árboles Comprados</h1>

        <div class="overflow-x-auto w-full max-w-4xl">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-green-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Especie</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Ubicación</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tamaño</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Precio</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Foto</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    // Mostrar la lista de árboles comprados por el usuario
                    if ($result->num_rows > 0) {
                        while ($arbol = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$arbol['nombre_comercial']}</td>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$arbol['ubicacion']}</td>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$arbol['size']}</td>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$arbol['precio']}</td>
                                    <td class='px-6 py-4'>
                                        <img src='actions/files/{$arbol['foto']}' alt='Foto del árbol' class='w-24 h-24 object-cover rounded-md'>
                                    </td>
                                  </tr>";
                        }
                    } 
                    // Si el usuario no ha comprado árboles, mostrar un mensaje
                    else {
                        echo "<tr>
                                <td colspan='5' class='px-6 py-4 text-center text-sm text-gray-500'>No has comprado ningún árbol.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <button onclick="window.location.href='users.php'" 
                class="mt-6 inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Atrás
        </button>
    </div>
</body>

</html>
