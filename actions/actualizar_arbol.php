<?php
require('../utils/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];
    $tamano = $_POST['tamano'];

    $conn = getConnection();
    // SQL if image changes
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $rutaFoto = $_SERVER['DOCUMENT_ROOT'] . "/ISW613/Proyecto1_Web1/actions/files/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto);
        $sql = "UPDATE arboles SET ubicacion = ?, estado = ?, precio = ?, foto = ?, size = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdssii', $ubicacion, $estado, $precio, $foto, $tamano, $id);
    } else {
        // SQL with not image changes
        $sql = "UPDATE arboles SET ubicacion = ?, estado = ?, precio = ?, size = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdsii', $ubicacion, $estado, $precio, $tamano, $id);
    }

    if ($stmt->execute()) {
        header('Location: ../arboles_CRUD.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
