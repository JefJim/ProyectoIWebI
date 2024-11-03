<?php
session_start();
require('utils/functions.php');

// check if the user is authenticated and is not an administrator
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 1) {
    header('Location: /access_denied.php');
    exit();
}

// Get the user ID currently logged in
$user_id = $_SESSION['user']['id'];

// Get the connection
$conn = getConnection();

// Get the list of trees purchased by the user
$sql = "SELECT trees.*, species.name_trade 
        FROM trees 
        JOIN species ON trees.species = species.id 
        WHERE trees.userId = ? AND trees.status = 1"; // Trees purchased by the user
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
    <title>My Trees</title>
</head>

<body class="h-full">
    <div class="min-h-full flex flex-col items-center py-8">
        <h1 class="text-3xl font-bold text-green-900 mb-6">My purchased trees</h1>
        <div class="overflow-x-auto w-full max-w-4xl">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-green-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Species</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Ubication</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Size</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Price</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Photo</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    // Show the list of trees purchased by the user
                    echo ($user_id);
                    if ($result->num_rows > 0) {
                        while ($tree = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$tree['name_trade']}</td>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$tree['ubication']}</td>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$tree['size']}</td>
                                    <td class='px-6 py-4 text-sm text-green-900'>{$tree['price']}</td>
                                    <td class='px-6 py-4'>
                                        <img src='actions/files/{$tree['photo']}' alt='photo of the tree' class='w-24 h-24 object-cover rounded-md'>
                                    </td>
                                  </tr>";
                        }
                    } 
                    // If the user has not purchased any trees, show a message
                    else {
                        echo "<tr>
                                <td colspan='5' class='px-6 py-4 text-center text-sm text-gray-500'>You haven't bought any tree.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <button onclick="window.location.href='users.php'" 
                class="mt-6 inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Back
        </button>
    </div>
</body>

</html>
