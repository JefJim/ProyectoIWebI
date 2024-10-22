<?php
require('../utils/functions.php'); 

// Verifica intento de inicio de sesión
if ($_POST) {
    $email = $_POST['email']; // Captura 
    $password = $_POST['password']; // Captura 

    // Llama a la función de autenticación para validar las credenciales 
    $user = authenticate($email, $password);

    // Si la autenticación es exitosa
    if ($user) {
        session_start(); // Inicia una nueva sesión

        $_SESSION['user'] = $user; // Almacena los datos del usuario en la sesión

        // Verifica si el usuario es un administrador
        if ($user['isAdmin'] == 1) {
            header('Location: /admin.php'); // Redirige a la página de administrador
            exit(); 
        } else {
            header('Location: /users.php'); // Redirige a la página de usuario estándar
            exit(); 
        }
    } else {
        // Redirige a la página de error si la autenticación falla
        header('Location: /login_error.php');
        exit(); 
    }
}
?>
