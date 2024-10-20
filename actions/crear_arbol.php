<?php
require('../utils/functions.php');
$especies = getEspecies();
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
    
    $especie_id = 0;
    foreach($especies as $id => $specie) {
        if ($id == $especie){
            $especie_id = $specie['id'];
        }
    }
    $estado_final;
    
    if ($estado == "0") {
        $estado_final = 0;
    } elseif ($estado == "1") {
        $estado_final = 1;
    }


    if (!file_exists($url_insert)) {
        mkdir($url_insert, 0777, true);
    };

    if (move_uploaded_file($url_temp, $url_target)) {
        $sql = "INSERT INTO arboles (especie, ubicacion, estado, precio, foto, size) 
                VALUES ('$especie_id', '$ubicacion', '$estado_final', '$precio', '$file', '$tamano')";
          try {
        $conn = getConnection();
        if (mysqli_query($conn, $sql)) {
            header('Location: ../arboles_CRUD.php?mensaje=exito');
        } else {
            header('Location: ../arboles_CRUD.php?mensaje=error');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    echo "Error al subir la foto.";
}
    
}
?>
