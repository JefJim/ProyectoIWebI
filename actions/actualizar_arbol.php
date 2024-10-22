<?php
require('../utils/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar datos del formulario
    $id = $_POST['id'];
    $ubicacion = $_POST['ubicacion'];
    $estado = (int) $_POST['estado']; // Convertir el estado a entero
    $precio = $_POST['precio'];
    $tamano = $_POST['tamano'];

    $conn = getConnection(); // Obtener conexión a la base de datos

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error()); // Manejar errores
    }

    // Verificar si se subió una nueva foto
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $rutaFoto = $_SERVER['DOCUMENT_ROOT'] . "/ISW613/Proyecto1_Web1/actions/files/" . basename($foto);
        
        // Mover la foto a la carpeta correspondiente
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto)) {
            exit(); // Salir si hay error al mover la foto
        }

        // SQL para actualizar el árbol con nueva foto
        $sql = "UPDATE arboles SET ubicacion = ?, estado = ?, precio = ?, foto = ?, size = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdsisi', $ubicacion, $estado, $precio, $foto, $tamano, $id);
    } else {
        // SQL para actualizar el árbol sin cambiar la foto
        $sql = "UPDATE arboles SET ubicacion = ?, estado = ?, precio = ?, size = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdssi', $ubicacion, $estado, $precio, $tamano, $id);
    }

    // Ejecutar la actualización del árbol
    if ($stmt->execute()) {
        // Insertar registro de la actualización en la tabla actualizaciones_arboles
        $sql_actualizacion = "INSERT INTO actualizaciones_arboles (arbol_id, tamano_actual, estado_actual) 
                              VALUES (?, ?, ?)";
        $stmt_actualizacion = $conn->prepare($sql_actualizacion);
        $stmt_actualizacion->bind_param('isi', $id, $tamano, $estado);

        // Verificar si la inserción de la actualización fue exitosa
        if ($stmt_actualizacion->execute()) {
            // Redirigir a la página con mensaje de éxito
            header('Location: ../arboles_CRUD.php?mensaje=actualizado');
            exit();
        }
    }

    $stmt->close(); // Cerrar statement
    $conn->close(); // Cerrar conexión
}
?>
