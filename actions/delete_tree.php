<?php
require('../utils/functions.php');
//just an sql to delete a tree with the id
$conn=getConnection();
$id = $_GET['id'];
$conn->query("DELETE FROM trees WHERE id = $id");
header('Location: ../trees_CRUD.php');
?>