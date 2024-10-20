<?php require ('utils/functions.php'); 
$especies = getEspecies();
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'exito') {
        echo "<p style='color: green;'>El árbol se ha registrado correctamente.</p>";
    } elseif ($_GET['mensaje'] == 'error') {
        echo "<p style='color: red;'>Hubo un problema al registrar el árbol.</p>";
    }
}

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
<form action="actions/crear_arbol.php" method="POST" enctype="multipart/form-data">
    <label for="especie">Especie:</label>
    <select name="especie" required>
        <option value="">Seleccione una especie</option>
        <?php
          foreach($especies as $id => $especie) {
            echo "<option value=\"$id\">$especie[nombre_comercial]</option>";
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

    <label for="tamano">Tamaño: </label>
    <input type="text" name="tamano" required><br><br>

    
   
    <button type="submit">Guardar Árbol</button>
    <button onclick="window.location.href='admin.php'">Atrás</button>
    
</form>

<h2>Árboles en Venta</h2>
<form>
    <table border="1">
        <tr>
            <th>Especie</th>
            <th>Ubicación</th>
            <th>Estado</th>
            <th>Precio</th>
            <th>Foto</th>
            <th>Tamaño</th>
            <th>Acciones</th>
        </tr>

        <?php
        $sql = "SELECT arboles.*, especies.nombre_comercial 
                FROM arboles 
                JOIN especies ON arboles.especie = especies.id";

        try {
            $conn = getConnection();
            $result = mysqli_query($conn, $sql); // Execute query

            // Check if rows exist
            if (mysqli_num_rows($result) > 0) {
                // Fetch each row and display it in a table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['nombre_comercial']}</td>
                            <td>{$row['ubicacion']}</td>
                            <td>" . ($row['estado'] ? 'Vendido' : 'Disponible') . "</td>
                            <td>{$row['precio']}</td>
                            <td><img src='actions/files/{$row['foto']}' width='100'></td>
                            <td>{$row['size']}</td>
                            <td>
                                <a href='actions/editar_arbol.php?id={$row['id']}'>Editar</a> |
                                <a href='actions/eliminar_arbol.php?id={$row['id']}'>Eliminar</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay árboles registrados</td></tr>";
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
        ?>
    </table>
</form>

</body>
</html>
