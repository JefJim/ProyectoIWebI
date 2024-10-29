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

<!doctype html>
<html class="h-full bg-green-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Administrar Amigos</title>
</head>

<body class="h-full">
  <div class="min-h-full">
    <?php define("_title_", "Administrar Amigos");
    require("./inc/adminNave.php"); ?>
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-green-500 dark:text-green-400">
        <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-400">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              Amigo
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>

          <?php
          // Mostrar la lista de amigos
          if (mysqli_num_rows($result) > 0) {
            while ($amigo = mysqli_fetch_assoc($result)) {
              // Mostrar el nombre y un enlace para ver los árboles del amigo
              echo "<tr class='bg-white border-b dark:bg-green-800 dark:border-green-700'>
                      <th scope='row' class='px-6 py-4 font-medium text-green-900 whitespace-nowrap dark:text-white'>
                        {$amigo['nombre']} {$amigo['apellido']}
                      </th>
                      <td class='px-6 py-4'>
                        <a href='ver_arboles_amigo.php?amigo_id={$amigo['id']}p' class='rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white' aria-current='page'>Ver Árboles</a>
                      </td>
                    </tr>";
            }
          }
          // Si no hay amigos registrados, mostrar un mensaje
          else {
            echo "<tr>
              <td colspan='2' class='px-6 py-4'>
                No hay amigos registrados
              </td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php require('inc/footer.php') ?>
</body>
</div>

</html>