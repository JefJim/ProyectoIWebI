<?php
require('utils/functions.php');
$conn = getConnection();
// create new species
if (isset($_POST['create'])) {
    $nametrade = $_POST['name_trade'];
    $namescientific = $_POST['name_scientific'];

    $conn->query("INSERT INTO species (name_trade, name_scientific) 
                VALUES ('$nametrade', '$namescientific')");
}

// delete species
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM species WHERE id=$id");
}

// get all species
$species = $conn->query("SELECT * FROM species");
?>

<!doctype html>
<html class="h-full bg-green-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Manage species</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php define("_title_", "Manage species");
        require("./inc/adminNave.php"); ?>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-green-500 dark:text-green-400">
                <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Trade name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Scientific name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    //printing species in the table
                    while ($row = $species->fetch_assoc()): ?>
                        <tr class="bg-white border-b dark:bg-green-800 dark:border-green-700">
                            <th scope="row" class="px-6 py-4 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['id']; ?>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['name_trade']; ?>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['name_scientific']; ?>
                            </th>
                            <td class="px-6 py-4">
                                <a href="edit_species.php?id=<?php echo $row['id']; ?>" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Edit</a>
                                | <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas delete esta species?')" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <br />
        <form action="" method="POST">
            <div class="space-y-12 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="border-b border-green-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-green-900">Add species</h2>
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="name_trade" class="block text-sm font-medium leading-6 text-green-900">Trade name</label>
                            <div class="mt-2">
                                <input type="text" name="name_trade" required id="name_trade" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="name_scientific" class="block text-sm font-medium leading-6 text-green-900">Scientific name</label>
                            <div class="mt-2">
                                <input type="text" name="name_scientific" required id="name_scientific" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" name="create" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-green shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Add species</button>
                </div>
            </div>
        </form>
    </div>
</body>
<?php require('inc/footer.php') ?>

</html>