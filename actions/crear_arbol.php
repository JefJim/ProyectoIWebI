<?php
require('../utils/functions.php');

// Obtener las especies para el formulario
$especies = getEspecies();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar datos del formulario
    $especie = $_POST['especie'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];
    $tamano = $_POST['tamano'];

    // Crear el directorio para las imágenes si no existe
    $file = $_FILES['foto']['name'];
    $url_temp = $_FILES['foto']['tmp_name'];
    $url_insert = dirname(__FILE__) . "/files";
    $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;

    // Obtener el ID correcto de la especie seleccionada
    $especie_id = 0;
    foreach ($especies as $id => $specie) {
        if ($id == $especie) {
            $especie_id = $specie['id'];
        }
    }

    // Convertir el valor de estado a entero
    $estado_final = ($estado == "0") ? 0 : 1;

    // Crear el directorio si no existe
    if (!file_exists($url_insert)) {
        mkdir($url_insert, 0777, true);
    }

    // Mover la imagen a la carpeta de destino y guardar el nuevo árbol
    if (move_uploaded_file($url_temp, $url_target)) {
        // consulta para insertar el nuevo árbol en la base de datos

        //get date and hour current in the server
        $currentTimestamp = date('Y-m-d H:i:s');
        $sql = "INSERT INTO arboles (especie, ubicacion, estado, precio, foto, size, last_update) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isissss', $especie_id, $ubicacion, $estado_final, $precio, $file, $tamano, $currentTimestamp);

        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            // Redirigir con un mensaje de éxito
            header('Location: ../arboles_CRUD.php?mensaje=exito');
            exit();
        } else {
            // Redirigir con un mensaje de error
            header('Location: ../arboles_CRUD.php?mensaje=error');
            exit();
        }
    } else {
        echo "Error al subir la foto.";
    }
}
?>
