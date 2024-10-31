<?php
session_start();
require('utils/functions.php');

// check if the user is authenticated and is not an administrator
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 1) {
  header('Location: /access_denied.php');
  exit();
}

$conn = getConnection();

$mensaje = $_GET['mensaje'] ?? ''; 

// Get the list of available trees
$sql = "SELECT trees.*, species.name_trade 
        FROM trees 
        JOIN species ON trees.species = species.id 
        WHERE trees.status = 0"; // only show available trees
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es" class="h-full bg-green-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Available trees</title>
</head>

<body class="h-full">
  <div class="min-h-full flex flex-col items-center py-8">
    <h1 class="text-3xl font-bold text-green-900 mb-6">Trees available for purchase</h1>

    <!-- Show successful purchase message -->
    <?php if ($mensaje == 'compra_exitosa') : ?>
      <p class="mb-4 text-green-600">¡successful purchase!</p>
    <?php elseif ($mensaje == 'error') : ?>
      <p class="mb-4 text-red-600">error when making the purchase.</p>
    <?php endif; ?>

    <!-- Button to view purchased trees -->
    <div class="mb-6">
      <button onclick="window.location.href='my_trees.php'" 
              class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
        My Trees
      </button>
    </div>

    <!-- table of available trees -->
    <div class="overflow-x-auto w-full max-w-4xl">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-green-800 text-white">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">Species</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Ubication</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Size</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Price</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Photo</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          // show the list of available trees
          if (mysqli_num_rows($result) > 0) {
            while ($tree = mysqli_fetch_assoc($result)) {
              echo "<tr class='border-b'>
                      <td class='px-6 py-4 text-sm text-green-900'>{$tree['name_trade']}</td>
                      <td class='px-6 py-4 text-sm text-green-900'>{$tree['ubication']}</td>
                      <td class='px-6 py-4 text-sm text-green-900'>{$tree['size']}</td>
                      <td class='px-6 py-4 text-sm text-green-900'>{$tree['price']}</td>
                      <td class='px-6 py-4'>
                        <img src='actions/files/{$tree['photo']}' alt='photo of the tree' class='w-24 h-24 object-cover rounded-md'>
                      </td>
                      <td class='px-6 py-4'>
                        <a href='/actions/buy_tree.php?id={$tree['id']}' 
                           class='text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md'>
                          buy
                        </a>
                      </td>
                    </tr>";
            }
          } 
          // if there are no available trees, show a message
          else {
            echo "<tr><td colspan='6' class='px-6 py-4 text-center text-sm text-gray-500'>There are no trees available.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- button for log out -->
    <div class="mt-6">
      <button onclick="window.location.href='actions/logout.php'" 
              class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
        Log out
      </button>
    </div>
  </div>
  <?php require('inc/footer.php')?>
</body>

</html>
