<?php
require('../utils/functions.php');

// get all species 
$species = getspecies();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $species_selected = $_POST['species'];
    $ubication = $_POST['ubication'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $size = $_POST['size'];

    // Create directory for images if it doesn't exist
    $file = $_FILES['photo']['name'];
    $url_temp = $_FILES['photo']['tmp_name'];
    $url_insert = dirname(__FILE__) . "/files";
    $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;

    // Get the correct ID of the selected species
    $species_id = 0;
    if (is_array($species)) {
        foreach ($species as $specie) {
            if ($specie['id'] == $species_selected) {
                $species_id = $specie['id'];
                break;
            }
        }
    }

    // Verify that the species ID is valid
    if ($species_id === 0) {
        die("Error: The selected species ID is invalid.");
    }

    // Convert state value to integer
    $status_final = ($status == "0") ? 0 : 1;

    // Create directory if it does not exist
    if (!file_exists($url_insert)) {
        mkdir($url_insert, 0777, true);
    }

    // Move the image to the destination folder and save the new tree
    if (move_uploaded_file($url_temp, $url_target)) {
        $currentTimestamp = date('Y-m-d H:i:s');
        $sql = "INSERT INTO trees (species, ubication, status, price, photo, size, last_update) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isissss', $species_id, $ubication, $status_final, $price, $file, $size, $currentTimestamp);

        if ($stmt->execute()) {
            header('Location: ../trees_CRUD.php?mensaje=exito');
            exit();
        } else {
            header('Location: ../trees_CRUD.php?mensaje=error');
            exit();
        }
    } else {
        echo "Error uploading photo.";
    }
}
?>
