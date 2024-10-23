<?php
require('utils/functions.php');
$conn = getConnection();
//get id of the species the user wants to edit
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM especies WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['actualizar'])) {
    $nombreComercial = $_POST['nombre_comercial'];
    $nombreCientifico = $_POST['nombre_cientifico'];
    //sql to update
    $conn->query("UPDATE especies 
                  SET nombre_comercial='$nombreComercial', nombre_cientifico='$nombreCientifico' 
                  WHERE id=$id");

    header('Location: CRUD_especies.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Especie</title>
</head>
<body>
    <h1>Editar Especie</h1>
    <form action="" method="POST">
        <input type="text" name="nombre_comercial" value="<?php echo $row['nombre_comercial']; ?>" required>
        <input type="text" name="nombre_cientifico" value="<?php echo $row['nombre_cientifico']; ?>" required>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
    <?php require('inc/footer.php')?>
</body>
</html>
