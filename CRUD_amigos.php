<?php
session_start();
require('utils/functions.php');

// Verifica si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
  header('Location: /access_denied.php');
  exit();
}

$conn = getConnection();

// Obtener la lista de amigos
$sql = "SELECT id, nombre, apellido FROM usuarios WHERE isAdmin = 0";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrar Amigos</title>
</head>

<body>

  <h1>Lista de Amigos Registrados</h1>

  <table border="1">
    <tr>
      <th>Nombre</th>
      <th>Acciones</th>
    </tr>

    <?php
    // Mostrar la lista de amigos
    if (mysqli_num_rows($result) > 0) {
      while ($amigo = mysqli_fetch_assoc($result)) {
        // Mostrar el nombre y un enlace para ver los árboles del amigo
        echo "<tr>
                  <td>{$amigo['nombre']} {$amigo['apellido']}</td>
                  <td><a href='ver_arboles_amigo.php?amigo_id={$amigo['id']}'>Ver Árboles</a></td>
                </tr>";
      }
    } 
    // Si no hay amigos registrados, mostrar un mensaje
    else {
      echo "<tr><td colspan='2'>No hay amigos registrados</td></tr>";
    }
    ?>
  </table>

  <button onclick="window.location.href='admin.php'">Volver al Dashboard</button>

</body>

</html>
