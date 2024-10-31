<?php
require('../utils/functions.php');
$conn = getConnection();

// get the tree ID 
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$tree;
// Check if the tree ID was provided
if (!$id) {
    die("ID not provided.");
}

// Get the current data of the tree if it is a GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = $conn->prepare("SELECT * FROM trees WHERE id = ?");
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();

    // Check if the tree exists
    $tree = $result->fetch_assoc();
    if (!$tree) {
        die("Tree not found.");
    }
}

// Update the tree data if it is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $conn->prepare("SELECT * FROM trees WHERE id = ?");
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();

    // Check if the tree exists
    $tree = $result->fetch_assoc();
    if (!$tree) {
        die("Tree not found.");
    }
    // Capture the data from the form
    $ubication = $_POST['ubication'];
    $status = (int) $_POST['status']; // convert state to integer
    $price = $_POST['price'];
    $size = $_POST['size'];

    // Manage photo: Use current photo if no new one is selected
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $routephoto = $_SERVER['DOCUMENT_ROOT'] . "/ISW613/Proyecto1_Web1/actions/files/" . basename($photo);

        // Move the photo to the corresponding folder
        move_uploaded_file($_FILES['photo']['tmp_name'], $routephoto);
    } else {
        $photo = $tree['photo']; // Use the current photo
    }

    // Check that the photo is not null
    if (empty($photo)) {
        die("Error: The photo cannot be null");
    }
    $currentTimestamp = date('Y-m-d H:i:s');
    // Update the tree data
    $sql = "UPDATE trees SET ubication = ?, status = ?, price = ?, photo = ?, size = ?, last_update = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sissisi', $ubication, $status, $price, $photo, $size, $currentTimestamp, $id);

    // check if the update was successful
    if ($stmt->execute()) {
        // Redirect with a success message
        header('Location: ../trees_CRUD.php?mensaje=editado');
        exit();
    } else {
        echo "Error updating tree " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es" class="h-full bg-green-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Tree</title>
</head>
<body class="h-full">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-green-900">Edit Tree</h2>
            <form action="" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                <input type="hidden" name="id" value="<?= $tree['id'] ?>">

                <div>
                    <label for="ubication" class="block text-sm font-medium text-green-900">Geographic location</label>
                    <input type="text" name="ubication" value="<?= $tree['ubication'] ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-green-900">Status</label>
                    <select name="status" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                        <option value="0" <?= $tree['status'] == 0 ? 'selected' : '' ?>>Available</option>
                        <option value="1" <?= $tree['status'] == 1 ? 'selected' : '' ?>>Sold</option>
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-green-900">Price</label>
                    <input type="number" name="price" step="0.01" value="<?= $tree['price'] ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-green-900">Photo of the tree (optional)</label>
                    <input type="file" name="photo" accept="image/*" 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="size" class="block text-sm font-medium text-green-900">Size</label>
                    <input type="text" name="size" value="<?= $tree['size'] ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="submit" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Update Tree
                    </button>
                    <button type="button" onclick="window.location.href='../trees_CRUD.php'" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-300 py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Back
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
