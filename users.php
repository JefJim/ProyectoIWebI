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
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Árboles Disponibles</title>
</head>

<body>

  <h1>Árboles Disponibles para Compra</h1>

  <!-- Mostrar mensaje de compra exitosa -->
  <?php if ($mensaje == 'compra_exitosa') : ?>
      <p style="color: green;">¡Compra realizada con éxito!</p>
  <?php elseif ($mensaje == 'error') : ?>
      <p style="color: red;">Hubo un error al realizar la compra.</p>
  <?php endif; ?>

  <!-- Botón para ver los árboles comprados -->
  <div style="margin-bottom: 20px;">
      <button onclick="window.location.href='mis_arboles.php'">Mis Árboles</button>
  </div>

  <table border="1">
    <tr>
      <th>Especie</th>
      <th>Ubicación</th>
      <th>Tamaño</th>
      <th>Precio</th>
      <th>Foto</th>
      <th>Acciones</th>
    </tr>

    <?php
    // Mostrar la lista de árboles disponibles
    if (mysqli_num_rows($result) > 0) {
      while ($arbol = mysqli_fetch_assoc($result)) {
        echo "<tr>
                    <td>{$arbol['nombre_comercial']}</td>
                    <td>{$arbol['ubicacion']}</td>
                    <td>{$arbol['size']}</td>
                    <td>{$arbol['precio']}</td>
                    <td><img src='actions/files/{$arbol['foto']}' width='100'></td>
                    <td><a href='/actions/comprar_arbol.php?id={$arbol['id']}'>Comprar</a></td>
                  </tr>";
      }
    } 
    // Si no hay árboles disponibles, mostrar un mensaje
    else {
      echo "<tr><td colspan='6'>No hay árboles disponibles</td></tr>";
    }
    ?>
  </table>
  <button onclick="window.location.href='actions/logout.php'">Cerrar Sesión</button>
  <?php require('inc/footer.php')?>
</body>

</html>
