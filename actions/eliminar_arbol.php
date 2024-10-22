<?php
require('../utils/functions.php');
//just an sql to delete a tree with the id
$conn=getConnection();
$id = $_GET['id'];
$conn->query("DELETE FROM arboles WHERE id = $id");
header('Location: ../arboles_CRUD.php');
?>