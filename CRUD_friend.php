<?php
session_start();
require('utils/functions.php');

// Session verification: user must be authenticated and be an administrator
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
  header('Location: /access_denied.php');
  exit();
}

$conn = getConnection();

// Get the list of friends
$sql = "SELECT id, name, last_name FROM users WHERE isAdmin = 0";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html class="h-full bg-green-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Manage friends</title>
</head>

<body class="h-full">
  <div class="min-h-full">
    <?php define("_title_", "Manage friends");
    require("./inc/adminNave.php"); ?>
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-green-500 dark:text-green-400">
        <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-400">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              Friend
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>

          <?php
          // show the list of friends
          if (mysqli_num_rows($result) > 0) {
            while ($friend = mysqli_fetch_assoc($result)) {
              // show the friend's name and a link to see their trees
              echo "<tr class='bg-white border-b dark:bg-green-800 dark:border-green-700'>
                      <th scope='row' class='px-6 py-4 font-medium text-green-900 whitespace-nowrap dark:text-white'>
                        {$friend['name']} {$friend['last_name']}
                      </th>
                      <td class='px-6 py-4'>
                        <a href='look_trees_friend.php?friend_id={$friend['id']}p' class='rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white' aria-current='page'>See trees</a>
                      </td>
                    </tr>";
            }
          }
          // if There are no registered friends, show a message
          else {
            echo "<tr>
              <td colspan='2' class='px-6 py-4'>
                There are no registered friends
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