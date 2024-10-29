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

<!doctype html>
<html class="h-full bg-green-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Árboles de Amigo</title>
</head>

<body class="h-full">
  <div class="min-h-full">
    <?php define("_title_", "Árboles de Amigo");
    require("./inc/adminNave.php"); ?>

    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-green-500 dark:text-green-400">
        <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-400">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              Especie
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Ubicación
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Tamaño
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Estado
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>

          <?php
          // Check if the query executed correctly
          if (!$result) {
            echo "Error in query execution: " . mysqli_error($conn); // Show any SQL error
            exit; // Stop the script if there's an error
          }

          // Check if there are any results
          if (mysqli_num_rows($result) == 0) {
            echo "No hay árboles registrados para este amigo.";
            exit; // Stop the script if no results are found
          }
          // printing species in the table
          while ($arbol = mysqli_fetch_assoc($result)):
            $estado = $arbol['estado'] == 1 ? 'Vendido' : 'Disponible';

            if ($arbol):
          ?>
              <tr class="bg-white border-b dark:bg-green-800 dark:border-green-700">
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $arbol['nombre_comercial']; ?>
                </th>
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $arbol['ubicacion']; ?>
                </th>
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $arbol['size']; ?>
                </th>
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $estado; ?>
                </th>
                <td class="px-6 py-4">
                  <a href="../actions/editar_arbol.php?id=<?php echo $arbol['id']; ?>" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Editar</a>
                  |
                  <a href="../actions/eliminar_arbol.php?id=<?php echo $arbol['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta especie?')" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Eliminar</a>
                </td>
              </tr>
            <?php
            else:
            ?>
              <tr>
                <td colspan="5" class="px-6 py-4">
                  No hay árboles registrados para este amigo.
                </td>
              </tr>
          <?php
            endif;
          endwhile;
          ?>
        </tbody>
      </table>
    </div>
</body>

</html>