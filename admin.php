<?php
session_start();

// check if the user is an administrator
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
    header('Location: /access_denied.php');
    exit();
}

// Path to the process file
$processPath = $_SERVER['DOCUMENT_ROOT'] . '/actions/process.php';

// Check if the file exists and display the path
if (file_exists($processPath)) {
    include($processPath);
} else {
    echo "Error: No se pudo encontrar el archivo process.php en $processPath.";
}

// Set default values ​​if variables are not defined
$totalfriends = isset($resultfriends['total_friends']) ? $resultfriends['total_friends'] : 0;
$treesDisponibles = isset($resultDisponibles['trees_disponibles']) ? $resultDisponibles['trees_disponibles'] : 0;
$treesVendidos = isset($resultVendidos['trees_vendidos']) ? $resultVendidos['trees_vendidos'] : 0;
?>

<!doctype html>
<html class="h-full bg-green-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php define("_title_", "Dashboard");
    require("./inc/adminNave.php"); ?>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div>
                    <div class="mt-6 border-t border-green-100">
                        <dl class="divide-y divide-green-100">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-green-900">Registered Friends</dt>
                                <dd class="mt-1 text-sm leading-6 text-green-700 sm:col-span-2 sm:mt-0"><?php echo $totalfriends; ?></dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-green-900">Available Trees</dt>
                                <dd class="mt-1 text-sm leading-6 text-green-700 sm:col-span-2 sm:mt-0"><?php echo $treesDisponibles; ?></dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-green-900">Sold Trees</dt>
                                <dd class="mt-1 text-sm leading-6 text-green-700 sm:col-span-2 sm:mt-0"><?php echo $treesVendidos; ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require('inc/footer.php') ?>
</body>

</html>