<?php
require('../utils/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captue data from the form
    $id = $_POST['id'];
    $ubication = $_POST['ubication'];
    $status = (int) $_POST['status']; // Convert state to integer
    $price = $_POST['price'];
    $size = $_POST['size'];

    $conn = getConnection(); // Get connection

    if (!$conn) {
        die("Error of connection: " . mysqli_connect_error()); // Connection error
    }

    // Check if a new photo was uploaded
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $routephoto = $_SERVER['DOCUMENT_ROOT'] . "/ISW613/Proyecto1_Web1/actions/files/" . basename($photo);
        
        // move the photo to the corresponding folder
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $routephoto)) {
            exit(); // Exit if the photo was not uploaded
        }

        // SQL for update the tree with new photo
        $sql = "UPDATE trees SET ubication = ?, status = ?, price = ?, photo = ?, size = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdsisi', $ubication, $status, $price, $photo, $size, $id);
    } else {
        // SQL for update the tree without changing the photo
        $sql = "UPDATE trees SET ubication = ?, status = ?, price = ?, size = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdssi', $ubication, $status, $price, $size, $id);
    }

    $stmt->close(); // close statement
    $conn->close(); // close connection
}
?>
