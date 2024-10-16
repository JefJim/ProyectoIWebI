<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$name = "";

// "if" for delete a warning on header, then just call $name
if ($user == null) {
  $name = "" ;
  } 
  else {
    $name = $user['firstname'];
  }

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="navId">
    <li class="nav-item">
      <a href="/signup.php" class="nav-link active">Signup</a>
    </li>
    <li class="nav-item">
      <a href="/login.php" class="nav-link active">Login</a>
    </li>
    <li class="nav-item">
      <a href="/actions/logout.php" class="nav-link active">Logout</a>
    </li>

    <li class="nav-item">
      <a href="/users.php" class="nav-link">Users</a>
    </li>
    <li>
      Hola <?php echo $name;
         ?>
    </li>
  </ul>
