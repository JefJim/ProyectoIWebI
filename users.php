<?php
session_start();
require('utils/functions.php');

// Verifica si el usuario ha iniciado sesión y si no es administrador
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 1) {
  header('Location: /access_denied.php');
  exit();
}

$conn = getConnection();

$mensaje = $_GET['mensaje'] ?? ''; 

// Obtener la lista de árboles disponibles para la compra
$sql = "SELECT arboles.*, especies.nombre_comercial 
        FROM arboles 
        JOIN especies ON arboles.especie = especies.id 
        WHERE arboles.estado = 0"; // Solo muestra árboles disponibles
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es" class="h-full bg-green-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Árboles Disponibles</title>
</head>

<body class="h-full">
  <div class="min-h-full flex flex-col items-center py-8">
    <h1 class="text-3xl font-bold text-green-900 mb-6">Árboles Disponibles para Compra</h1>

    <!-- Mostrar mensaje de compra exitosa -->
    <?php if ($mensaje == 'compra_exitosa') : ?>
      <p class="mb-4 text-green-600">¡Compra realizada con éxito!</p>
    <?php elseif ($mensaje == 'error') : ?>
      <p class="mb-4 text-red-600">Hubo un error al realizar la compra.</p>
    <?php endif; ?>

    <!-- Botón para ver los árboles comprados -->
    <div class="mb-6">
      <button onclick="window.location.href='mis_arboles.php'" 
              class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
        Mis Árboles
      </button>
    </div>

    <!-- Tabla de árboles disponibles -->
    <div class="overflow-x-auto w-full max-w-4xl">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-green-800 text-white">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">Especie</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Ubicación</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Tamaño</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Precio</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Foto</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          // Mostrar la lista de árboles disponibles
          if (mysqli_num_rows($result) > 0) {
            while ($arbol = mysqli_fetch_assoc($result)) {
              echo "<tr class='border-b'>
                      <td class='px-6 py-4 text-sm text-green-900'>{$arbol['nombre_comercial']}</td>
                      <td class='px-6 py-4 text-sm text-green-900'>{$arbol['ubicacion']}</td>
                      <td class='px-6 py-4 text-sm text-green-900'>{$arbol['size']}</td>
                      <td class='px-6 py-4 text-sm text-green-900'>{$arbol['precio']}</td>
                      <td class='px-6 py-4'>
                        <img src='actions/files/{$arbol['foto']}' alt='Foto del árbol' class='w-24 h-24 object-cover rounded-md'>
                      </td>
                      <td class='px-6 py-4'>
                        <a href='/actions/comprar_arbol.php?id={$arbol['id']}' 
                           class='text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md'>
                          Comprar
                        </a>
                      </td>
                    </tr>";
            }
          } 
          // Si no hay árboles disponibles, mostrar un mensaje
          else {
            echo "<tr><td colspan='6' class='px-6 py-4 text-center text-sm text-gray-500'>No hay árboles disponibles</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Botón para cerrar sesión -->
    <div class="mt-6">
      <button onclick="window.location.href='actions/logout.php'" 
              class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
        Cerrar Sesión
      </button>
    </div>
  </div>
  <?php require('inc/footer.php')?>
</body>

</html>
