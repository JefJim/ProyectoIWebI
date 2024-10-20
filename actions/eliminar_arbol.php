<?php
require('../utils/functions.php');
$conn=getConnection();
$id = $_GET['id'];
$conn->query("DELETE FROM arboles WHERE id = $id");

header('Location: ../arboles_CRUD.php');
?>
