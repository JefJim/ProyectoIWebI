<?php
require($_SERVER['DOCUMENT_ROOT'] . '/utils/functions.php');
//$especies get an array with all species registered in the BD to select one and register a new tree
$especies = getEspecies();
$conn = getConnection();

// Obtener todas las arboles
$arboles = $conn->query("SELECT arboles.*, especies.nombre_comercial FROM arboles 
                            JOIN especies ON arboles.especie = especies.id");

?>

<!doctype html>
<html class="h-full bg-green-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Administrar Árboles</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php define("_title_", "Administrar Árboles");
        require("./inc/adminNave.php");
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] == 'exito') {
                echo "<p style='color: green;'>El árbol se ha registrado correctamente.</p>";
            } elseif ($_GET['mensaje'] == 'error') {
                echo "<p style='color: red;'>Hubo un problema al registrar el árbol.</p>";
            }
        }
        ?>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-green-500 dark:text-green-400">
                <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Especie
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Ubicación
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Precio
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Foto
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Tamaño
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    //printing species in the table
                    while ($row = $arboles->fetch_assoc()): ?>
                        <tr class="bg-white border-b dark:bg-green-800 dark:border-green-700">
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['nombre_comercial']; ?>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['ubicacion']; ?>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo ($row['estado'] ? 'Vendido' : 'Disponible'); ?>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['precio']; ?>
                            </th>
                            <th scope="row" class="px-2 py-2 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <img src="actions/files/<?php echo $row['foto']; ?>" style="border-radius: 4px;" width='100px'>
                            </th>
                            <th scope="row" class="px-6 py-8 font-medium text-green-900 whitespace-nowrap dark:text-white">
                                <?php echo $row['size']; ?>
                            </th>
                            <td class="px-6 py-4">
                                <a href="../actions/editar_arbol.php?id=<?php echo $row['id']; ?>" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Editar</a>
                                | <a href="../actions/eliminar_arbol.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta especie?')" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-green-700 hover:text-white" aria-current="page">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <br />
        <form action="actions/crear_arbol.php" method="POST" enctype="multipart/form-data">
            <div class="space-y-12 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="border-b border-green-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-green-900">Agregar Árboles</h2>
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="especie" class="block text-sm font-medium leading-6 text-gray-900">Especie:</label>
                            <div class="mt-2">
                                <select id="especie" name="especie" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">Seleccione una especie</option>
                                    <?php
                                    //print all species in the combobox
                                    foreach ($especies as $id => $especie) {
                                        echo "<option value=\"$id\">$especie[nombre_comercial]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="estado" class="block text-sm font-medium leading-6 text-gray-900">Estado:</label>
                            <div class="mt-2">
                                <select id="estado" name="estado" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="0">Disponible</option>
                                    <option value="1">Vendido</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="ubicacion" class="block text-sm font-medium leading-6 text-green-900">Ubicación Geográfica:</label>
                            <div class="mt-2">
                                <input type="text" name="ubicacion" required id="ubicacion" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="precio" class="block text-sm font-medium leading-6 text-green-900">Precio</label>
                            <div class="mt-2">
                                <input type="number" name="precio" required id="precio" step="0.01" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="foto" class="block text-sm font-medium leading-6 text-green-900">Foto del árbol</label>
                            <div class="mt-2">
                                <input type="file" name="foto" accept="image/*" required id="foto" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="tamano" class="block text-sm font-medium leading-6 text-green-900">Tamaño</label>
                            <div class="mt-2">
                                <input type="text" name="tamano" required id="tamano" class="block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" name="crear" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-green shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Agregar Árbol</button>
                </div>
            </div>
        </form>
    </div>
    <?php require('inc/footer.php') ?>
</body>

</html>