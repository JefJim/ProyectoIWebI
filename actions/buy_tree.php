<?php
require('../utils/functions.php');
session_start();

// Session verification: user must be authenticated and be a friend
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 1) {
    header('Location: /access_denied.php');
    exit();
}

// get the tree ID and the user ID
$tree_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user']['id']; // current friend id

// Check if tree ID was provided
if (!$tree_id) {
    die("Tree ID not provided.");
}

$conn = getConnection(); // Get connection

// Check if the tree is available for purchase
$sql = "SELECT * FROM trees WHERE id = ? AND status = 0"; //  0 "available" state
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $tree_id);
$stmt->execute();
$result = $stmt->get_result();
$tree = $result->fetch_assoc();

// Check if it exists and is available
if (!$tree) {
    die("The tree is not available for purchase.");
}

// Update the tree status to 'Sold' (status = 1) and associate it with the user
$sql = "UPDATE trees SET status = 1, userId = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $tree_id);

// Run the update and redirect the user with a success message
if ($stmt->execute()) {
    header('Location: /users.php?mensaje=compra_exitosa');
    exit();
}

$conn->close(); // close connection
?>
