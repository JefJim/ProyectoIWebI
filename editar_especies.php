<?php
require('utils/functions.php');
$conn = getConnection();
// Obtener el ID de la especie
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM especies WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['actualizar'])) {
    $nombreComercial = $_POST['nombre_comercial'];
    $nombreCientifico = $_POST['nombre_cientifico'];
    // SQL para actualizar
    $conn->query("UPDATE especies 
                  SET nombre_comercial='$nombreComercial', nombre_cientifico='$nombreCientifico' 
                  WHERE id=$id");

    header('Location: CRUD_especies.php');
}
?>

<!DOCTYPE html>
<html lang="es" class="h-full bg-green-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Editar Especie</title>
</head>
<body class="h-full">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h1 class="text-3xl font-extrabold text-center text-green-900">Editar Especie</h1>
            <form action="" method="POST" class="mt-8 space-y-6">
                <div>
                    <label for="nombre_comercial" class="block text-sm font-medium text-green-900">Nombre Comercial</label>
                    <input type="text" name="nombre_comercial" value="<?php echo $row['nombre_comercial']; ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="nombre_cientifico" class="block text-sm font-medium text-green-900">Nombre Científico</label>
                    <input type="text" name="nombre_cientifico" value="<?php echo $row['nombre_cientifico']; ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="submit" name="actualizar" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Actualizar
                    </button>
                    <button type="button" onclick="window.location.href='CRUD_especies.php'" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-300 py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Atrás
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php require('inc/footer.php')?>
</body>
</html>
