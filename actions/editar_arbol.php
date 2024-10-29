<?php
require('../utils/functions.php');
$conn = getConnection();

// Obtener el ID del árbol 
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$arbol;
// Verificar si el ID fue proporcionado
if (!$id) {
    die("ID no proporcionado.");
}

// Obtener los datos actuales del árbol si es una solicitud GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = $conn->prepare("SELECT * FROM arboles WHERE id = ?");
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();

    // Verificar si el árbol existe
    $arbol = $result->fetch_assoc();
    if (!$arbol) {
        die("Árbol no encontrado.");
    }
}

// Si es una solicitud POST, realizar la actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $conn->prepare("SELECT * FROM arboles WHERE id = ?");
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();

    // Verificar si el árbol existe
    $arbol = $result->fetch_assoc();
    if (!$arbol) {
        die("Árbol no encontrado.");
    }
    // Capturar los datos del formulario
    $ubicacion = $_POST['ubicacion'];
    $estado = (int) $_POST['estado']; // Convertir a entero
    $precio = $_POST['precio'];
    $tamano = $_POST['tamano'];

    // Manejar la foto: usar la foto actual si no se selecciona una nueva
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $rutaFoto = $_SERVER['DOCUMENT_ROOT'] . "/ISW613/Proyecto1_Web1/actions/files/" . basename($foto);

        // Mover la foto a la carpeta correspondiente
        move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto);
    } else {
        $foto = $arbol['foto']; // Usar la foto actual
    }

    // Asegurar que la foto nunca sea nula
    if (empty($foto)) {
        die("Error: La foto no puede ser nula.");
    }
    $currentTimestamp = date('Y-m-d H:i:s');
    // Actualizar los datos del árbol
    $sql = "UPDATE arboles SET ubicacion = ?, estado = ?, precio = ?, foto = ?, size = ?, last_update = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sissisi', $ubicacion, $estado, $precio, $foto, $tamano, $currentTimestamp, $id);

    // Verificar si la actualización fue exitosa
    if ($stmt->execute()) {
        // Redirigir con un mensaje de éxito
        header('Location: ../arboles_CRUD.php?mensaje=editado');
        exit();
    } else {
        echo "Error al actualizar el árbol: " . $stmt->error;
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
    <title>Editar Árbol</title>
</head>
<body class="h-full">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-green-900">Editar Árbol</h2>
            <form action="" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                <input type="hidden" name="id" value="<?= $arbol['id'] ?>">

                <div>
                    <label for="ubicacion" class="block text-sm font-medium text-green-900">Ubicación geográfica</label>
                    <input type="text" name="ubicacion" value="<?= $arbol['ubicacion'] ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="estado" class="block text-sm font-medium text-green-900">Estado</label>
                    <select name="estado" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                        <option value="0" <?= $arbol['estado'] == 0 ? 'selected' : '' ?>>Disponible</option>
                        <option value="1" <?= $arbol['estado'] == 1 ? 'selected' : '' ?>>Vendido</option>
                    </select>
                </div>

                <div>
                    <label for="precio" class="block text-sm font-medium text-green-900">Precio</label>
                    <input type="number" name="precio" step="0.01" value="<?= $arbol['precio'] ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="foto" class="block text-sm font-medium text-green-900">Foto del árbol (opcional)</label>
                    <input type="file" name="foto" accept="image/*" 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div>
                    <label for="tamano" class="block text-sm font-medium text-green-900">Tamaño</label>
                    <input type="text" name="tamano" value="<?= $arbol['size'] ?>" required 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-green-900 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="submit" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Actualizar Árbol
                    </button>
                    <button type="button" onclick="window.location.href='../arboles_CRUD.php'" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-300 py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Atrás
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
