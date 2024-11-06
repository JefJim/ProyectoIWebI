<?php
require('../utils/functions.php');

// Verify login
if ($_POST) {
    $email = $_POST['email']; // Captura 
    $password = $_POST['password']; // Captura 

    // Call the authentication function to validate credentials
    $user = authenticate($email, $password);

    // If authentication is successful
    if ($user) {
        session_start(); // start a new session

        $_SESSION['user'] = $user; // Stores user data in the session

        // Check if the user is an administrator
        if ($user['isAdmin'] == 1) {
            header('Location: /admin.php'); // Redirects to the admin page
            exit();
        }
        else if ($user['isAdmin'] == 0) {
            header('Location: /users.php'); // Redirects to the friends page
            exit();
        }
    } else {
        // Redirect to error page if authentication fails
        header('Location: /login_error.php');
        exit();
    }
}
