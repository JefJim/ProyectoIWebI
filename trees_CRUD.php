<?php
require($_SERVER['DOCUMENT_ROOT'] . '/utils/functions.php');
//$species get an array with all species registered in the BD to select one and register a new tree
$species = getspecies();
$conn = getConnection();

// get all trees with their species
$trees = $conn->query("SELECT trees.*, species.name_trade FROM trees 
                            JOIN species ON trees.species = species.id");

?>

<!doctype html>
<html class="h-full bg-green-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Managing Trees</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php define("_title_", "Managing Trees");
        require("./inc/adminNave.php");
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] == 'success') {
                echo "<p style='color: green;'>The tree has been registered successfully.</p>";
            } elseif ($_GET['mensaje'] == 'error') {
                echo "<p style='color: red;'>There was a problem registering the tree.</p>";
            }
        }
        ?>
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
                            State
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Photo
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Size
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    //printing species in the table
                    while ($row = $trees->fetch_assoc()): ?>
                        <tr class="bg-white border-b dark:bg-green-800 dark:border-green-700">
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['name_trade']; ?>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['ubication']; ?>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo ($row['status'] ? 'Sold' : 'Available'); ?>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['price']; ?>
                            </th>
                            <th scope="row" class="px-2 py-2 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <img src="actions/files/<?php echo $row['photo']; ?>" style="border-radius: 4px;" width='100px'>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['size']; ?>
                            </th>
                            <td class="px-6 py-4">
                                <a href="../actions/edit_tree.php?id=<?php echo $row['id']; ?>" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Edit</a>
                                | <a href="../actions/delete_tree.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this tree?')" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <br />
        <form action="actions/create_tree.php" method="POST" enctype="multipart/form-data">
            <div class="space-y-12 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="border-b border-green-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-green-900">Add Trees</h2>
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="species" class="block text-sm font-medium leading-6 text-gray-900">Species:</label>
                            <div class="mt-2">
                                <select id="species" name="species" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">Select a species</option>
                                    <?php
                                    //print all species in the combobox
                                    foreach ($species as $id => $species) {
                                        echo "<option value=\"$id\">$species[name_trade]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Status:</label>
                            <div class="mt-2">
                                <select id="status" name="status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="0">Available</option>
                                    <option value="1">Sold</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="ubication" class="block text-sm font-medium leading-6 text-green-900">Geographic location:</label>
                            <div class="mt-2">
                                <input type="text" name="ubication" required id="ubication" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="price" class="block text-sm font-medium leading-6 text-green-900">Price</label>
                            <div class="mt-2">
                                <input type="number" name="price" required id="price" step="0.01" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="photo" class="block text-sm font-medium leading-6 text-green-900">Photo of the tree</label>
                            <div class="mt-2">
                                <input type="file" name="photo" accept="image/*" required id="photo" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="size" class="block text-sm font-medium leading-6 text-green-900">Size</label>
                            <div class="mt-2">
                                <input type="text" name="size" required id="size" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" name="create" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-green shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Add Tree</button>
                </div>
            </div>
        </form>
    </div>
    <?php require('inc/footer.php') ?>
</body>

</html>