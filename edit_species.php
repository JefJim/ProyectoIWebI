<?php
require('utils/functions.php');
$conn = getConnection();
// Obtener el ID de la species
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM species WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $nametrade = $_POST['name_trade'];
    $namescientific = $_POST['name_scientific'];
    // SQL para update
    $conn->query("UPDATE species 
                  SET name_trade='$nametrade', name_scientific='$namescientific' 
                  WHERE id=$id");

    header('Location: CRUD_species.php');
}
?>

<!DOCTYPE html>
<html lang="es" class="h-full bg-green-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit species</title>
</head>
<body class="h-full">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h1 class="text-3xl font-extrabold text-center text-green-900">Edit species</h1>
            <form action="" method="POST" class="mt-8 space-y-6">
                <div>
                    <label for="name_trade" class="block text-sm font-medium text-green-900">Trade name</label>
                    <input type="text" name="name_trade" value="<?php echo $row['name_trade']; ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="name_scientific" class="block text-sm font-medium text-green-900">Scientific name</label>
                    <input type="text" name="name_scientific" value="<?php echo $row['name_scientific']; ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="submit" name="update" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Update
                    </button>
                    <button type="button" onclick="window.location.href='CRUD_species.php'" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-300 py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Back
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php require('inc/footer.php')?>
</body>
</html>
