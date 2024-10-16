<?php require ('utils/functions.php'); 
$especies = getEspecies();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Árboles</title>
</head>
<body>

<h2>Crear Árbol</h2>
<form action="crear.php" method="POST" enctype="multipart/form-data">
    <label for="especie">Especie:</label>
    <select name="especie" required>
        <option value="">Seleccione una especie</option>
        <?php
          foreach($especies as $id => $especie) {
            echo "<option value=\"$id\">$especie</option>";
          }
          ?>
    </select><br><br>

    <label for="ubicacion">Ubicación geográfica:</label>
    <input type="text" name="ubicacion" required><br><br>

    <label for="estado">Estado:</label>
    <select name="estado" required>
        <option value="0">Disponible</option>
        <option value="1">Vendido</option>
    </select><br><br>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" step="0.01" required><br><br>

    <label for="foto">Foto del árbol:</label>
    <input type="file" name="foto" accept="image/*" required><br><br>

    <button type="submit">Guardar Árbol</button>
</form>

<h2>Árboles en Venta</h2>
<table border="1">
    <tr>
        <th>Especie</th>
        <th>Ubicación</th>
        <th>Estado</th>
        <th>Precio</th>
        <th>Foto</th>
        <th>Acciones</th>
    </tr>

    <?php
    $query = $pdo->query("SELECT arboles.*, especies.nombre_comercial 
                          FROM arboles 
                          JOIN especies ON arboles.especie = especies.id");

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
            <td>{$row['nombre_comercial']}</td>
            <td>{$row['ubicacion']}</td>
            <td>" . ($row['estado'] ? 'Vendido' : 'Disponible') . "</td>
            <td>{$row['precio']}</td>
            <td><img src='uploads/{$row['foto']}' width='100'></td>
            <td>
                <a href='editar.php?id={$row['id']}'>Editar</a> |
                <a href='eliminar.php?id={$row['id']}'>Eliminar</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
