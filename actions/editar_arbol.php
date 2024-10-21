<?php
require('../utils/functions.php');
$conn=getConnection();
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no proporcionado.");
}
//sql to get a tree with id
$query = $conn->prepare("SELECT * FROM arboles WHERE id = ?");
$query->bind_param('i', $id);
$query->execute();
$result = $query->get_result();

//$arbol returns an array to use then
$arbol = $result->fetch_assoc();

if (!$arbol) {
    die("Árbol no encontrado.");
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
<form action="actualizar_arbol.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $arbol['id'] ?>">

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
    <input type="number" name="tamano" value="<?= $arbol ['size'] ?>" required><br><br>

    <button type="submit">Actualizar Árbol</button>

    
</form>
    <button onclick="window.location.href='/../arboles_CRUD.php'">Atrás</button>
</body>
</html>
