<?php
session_start();

// Verifica si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
    header('Location: /access_denied.php');
    exit();
}

// usé esta ruta absoluta porque habían problemas con la búsqueda de process.php
$processPath = $_SERVER['DOCUMENT_ROOT'] . '/actions/process.php';

// Verifica si el archivo existe y muestra la ruta
if (file_exists($processPath)) {
    include($processPath);
} else {
    echo "Error: No se pudo encontrar el archivo process.php en $processPath.";
}

// Establecer valores predeterminados si las variables no están definidas
$totalAmigos = isset($resultAmigos['total_amigos']) ? $resultAmigos['total_amigos'] : 0;
$arbolesDisponibles = isset($resultDisponibles['arboles_disponibles']) ? $resultDisponibles['arboles_disponibles'] : 0;
$arbolesVendidos = isset($resultVendidos['arboles_vendidos']) ? $resultVendidos['arboles_vendidos'] : 0;
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
                                <dt class="text-sm font-medium leading-6 text-green-900">Amigos Registrados</dt>
                                <dd class="mt-1 text-sm leading-6 text-green-700 sm:col-span-2 sm:mt-0"><?php echo $totalAmigos; ?></dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-green-900">Árboles Disponibles</dt>
                                <dd class="mt-1 text-sm leading-6 text-green-700 sm:col-span-2 sm:mt-0"><?php echo $arbolesDisponibles; ?></dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-green-900">Árboles Vendidos</dt>
                                <dd class="mt-1 text-sm leading-6 text-green-700 sm:col-span-2 sm:mt-0"><?php echo $arbolesVendidos; ?></dd>
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