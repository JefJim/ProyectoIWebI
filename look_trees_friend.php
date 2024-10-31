<?php
session_start();
require('utils/functions.php');

// check if the user is authenticated and is an administrator
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
  // Redirect to the access denied page
  header('Location: /access_denied.php');
  exit();
}
// Get the friend ID 
$friend_id = $_GET['friend_id'] ?? null;
// Check if the friend ID was provided
if (!$friend_id) {
  die("ID del friend no proporcionado.");
}

$conn = getConnection();

// Get the friend's trees list
$sql = "SELECT trees.*, species.name_trade 
        FROM trees 
        JOIN species ON trees.species = species.id 
        WHERE trees.userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $friend_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html class="h-full bg-green-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Friend trees</title>
</head>

<body class="h-full">
  <div class="min-h-full">
    <?php define("_title_", "Friend trees");
    require("./inc/adminNave.php"); ?>

    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-green-500 dark:text-green-400">
        <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-400">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              Species
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Ubication
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Size
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Status
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Actions
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
            echo "There are no trees registered for this friend.";
            exit; // Stop the script if no results are found
          }
          // printing species in the table
          while ($tree = mysqli_fetch_assoc($result)):
            $status = $tree['status'] == 1 ? 'Sold' : 'Available';

            if ($tree):
          ?>
              <tr class="bg-white border-b dark:bg-green-800 dark:border-green-700">
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $tree['name_trade']; ?>
                </th>
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $tree['ubication']; ?>
                </th>
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $tree['size']; ?>
                </th>
                <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                  <?php echo $status; ?>
                </th>
                <td class="px-6 py-4">
                  <a href="../actions/edit_tree.php?id=<?php echo $tree['id']; ?>" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Edit</a>
                  |
                  <a href="../actions/delete_tree.php?id=<?php echo $tree['id']; ?>" onclick="return confirm('Are you sure you want to delete this tree?')" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Delete</a>
                </td>
              </tr>
            <?php
            else:
            ?>
              <tr>
                <td colspan="5" class="px-6 py-4">
                There are no trees registered for this friend
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