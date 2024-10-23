<?php
require ('utils/functions.php');
$conn= getConnection();
// Crear una nueva especie
if (isset($_POST['crear'])) {
    $nombreComercial = $_POST['nombre_comercial'];
    $nombreCientifico = $_POST['nombre_cientifico'];

    $conn->query("INSERT INTO especies (nombre_comercial, nombre_cientifico) 
                  VALUES ('$nombreComercial', '$nombreCientifico')");
}

// Eliminar una especie
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM especies WHERE id=$id");
}

// Obtener todas las especies
$especies = $conn->query("SELECT * FROM especies");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Especies</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Administrar Especies de Árboles</h1>

    <!-- Formulario de Creación -->
    <form action="" method="POST">
        <input type="text" name="nombre_comercial" placeholder="Nombre Comercial" required>
        <input type="text" name="nombre_cientifico" placeholder="Nombre Científico" required>
        <button type="submit" name="crear">Agregar Especie</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Comercial</th>
                <th>Nombre Científico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            //printing species in the table
            while ($row = $especies->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre_comercial']; ?></td>
                <td><?php echo $row['nombre_cientifico']; ?></td>
                <td>
                    
                    <a href="editar_especies.php?id=<?php echo $row['id']; ?>";>Editar</a> 
                    <a href="?delete=<?php echo $row['id']; ?>" 
                       onclick="return confirm('¿Seguro que deseas eliminar esta especie?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="window.location.href='admin.php'">Atrás</button>
    <?php require('inc/footer.php')?>
</body>
</html>
