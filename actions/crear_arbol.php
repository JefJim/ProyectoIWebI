<?php
require('../utils/functions.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $especie = $_POST['especie'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];
    $tamano = $_POST['tamano'];
    
    $file = $_FILES['foto']['name'];
    $url_temp = $_FILES['foto']['tmp_name'];

    $url_insert = dirname(__FILE__) . "/files";
    $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;

    if (!file_exists($url_insert)) {
        mkdir($url_insert, 0777, true);
    };

    if (move_uploaded_file($url_temp, $url_target)) {
        $sql = "INSERT INTO arboles (especie, ubicacion, estado, precio, foto, size) 
                VALUES ('$especie', '$ubicacion', '$estado', '$precio', '$file', '$tamano')";
        try {
        $conn = getConnection();
        mysqli_query($conn, $sql);
        header('Location: ..    /arboles_CRUD.php');
        } catch (Exception $e) {
        echo $e->getMessage();
        return false;
        }
        return true;
        
    } else {
        echo "Error al subir la foto.";
    }
    
}
?>
