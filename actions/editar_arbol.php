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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Árbol</title>
</head>
<body>

<h2>Editar Árbol</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $arbol['id'] ?>">

    <!-- Campos para editar la información del árbol -->
    <label for="ubicacion">Ubicación geográfica:</label>
    <input type="text" name="ubicacion" value="<?= $arbol['ubicacion'] ?>" required><br><br>

    <label for="estado">Estado:</label>
    <select name="estado" required>
        <option value="0" <?= $arbol['estado'] == 0 ? 'selected' : '' ?>>Disponible</option>
        <option value="1" <?= $arbol['estado'] == 1 ? 'selected' : '' ?>>Vendido</option>
    </select><br><br>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" step="0.01" value="<?= $arbol['precio'] ?>" required><br><br>

    <label for="foto">Foto del árbol (opcional):</label>
    <input type="file" name="foto" accept="image/*"><br><br>

    <label for="tamano">Tamaño: </label>
    <input type="text" name="tamano" value="<?= $arbol['size'] ?>" required><br><br>

    <button type="submit">Actualizar Árbol</button>
    <button onclick="window.location.href='../arboles_CRUD.php'">Atrás</button>
</form>

</body>
</html>
