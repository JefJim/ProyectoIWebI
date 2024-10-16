<?php
require '../utils/functions.php';

if($_POST && isset($_REQUEST['firstname'])) {
  //get each field and insert to the database
  $user['firstname'] = $_REQUEST['firstname'];
  $user['lastname'] = $_REQUEST['lastname'];
  $user['phone'] = $_REQUEST['phone'];
  $user['email'] = $_REQUEST['email'];
  $user['address'] = $_REQUEST['address'];
  $user['country'] = $_REQUEST['country'];
  $user['password'] = $_REQUEST['password'];

  if (saveUser($user)) {
    header( "Location: /users.php",);
  } else {
    header( "Location: /?error=Invalid user data");
  }
}