<?php
session_start();
require('utils/functions.php');

// Verifica si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
  // Redirige a la página de acceso denegado si no es administrador
  header('Location: /access_denied.php');
  exit();
}
// Obtener el ID del amigo
$amigo_id = $_GET['amigo_id'] ?? null;
// Verificar si se proporcionó el ID del amigo
if (!$amigo_id) {
  die("ID del amigo no proporcionado.");
}

$conn = getConnection();

// Obtener la lista de árboles comprados por el amigo
$sql = "SELECT arboles.*, especies.nombre_comercial 
        FROM arboles 
        JOIN especies ON arboles.especie = especies.id 
        WHERE arboles.userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $amigo_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Árboles de Amigo</title>
</head>

<body>

  <h1>Árboles de Amigo</h1>

  <table border="1">
    <tr>
      <th>Especie</th>
      <th>Ubicación</th>
      <th>Tamaño</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>

    <?php
    // Mostrar la lista de árboles comprados por el amigo
    if (mysqli_num_rows($result) > 0) {
      while ($arbol = mysqli_fetch_assoc($result)) {
        $estado = $arbol['estado'] == 1 ? 'Vendido' : 'Disponible';
        echo "<tr>
                  <td>{$arbol['nombre_comercial']}</td>
                  <td>{$arbol['ubicacion']}</td>
                  <td>{$arbol['size']}</td>
                  <td>$estado</td>
                  <td><a href='actions/editar_arbol.php?id={$arbol['id']}'>Editar</a></td>
                </tr>";
      }
    } else {
      echo "<tr><td colspan='5'>No hay árboles registrados para este amigo.</td></tr>";
    }
    ?>

  </table>

  <button onclick="window.location.href='CRUD_amigos.php'">Volver a la Lista de Amigos</button>
  <?php require('inc/footer.php')?>
</body>

</html>
