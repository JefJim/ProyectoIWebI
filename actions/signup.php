<?php
require '../utils/functions.php'; // Import the necessary functions

if ($_POST && isset($_POST['firstname'])) {
    // Capture the data from the form
    $user['firstname'] = $_POST['firstname'];
    $user['lastname'] = $_POST['lastname'];
    $user['phone'] = $_POST['phone'];
    $user['email'] = $_POST['email'];
    $user['address'] = $_POST['address'];
    $user['country'] = $_POST['country'];
    $user['password'] = $_POST['password']; // It is encrypted in saveUser, if it is encrypted here too, it does a double encryption and fails
    $user['isAdmin'] = 0; // friend

    // Calls the function to check if the mail already exists
    if (emailExists($user['email'])) {
        // If the email already exists, redirect to the registration error page
        header("Location: /signup_error.php");
        exit();
    }

    // if the email does not exist, save the user
    if (saveUser($user)) {
        header("Location: /login.php"); // Redirect to the login page late registration
        exit();
    } else {
        header("Location: /signup.php?error=Invalid user data"); // Redirect if there is an error in the registry
        exit();
    }
}
?>
