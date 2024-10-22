<?php
require '../utils/functions.php'; // Importa las funciones necesarias

if ($_POST && isset($_POST['firstname'])) {
    // Captura los campos del formulario de registro
    $user['firstname'] = $_POST['firstname'];
    $user['lastname'] = $_POST['lastname'];
    $user['phone'] = $_POST['phone'];
    $user['email'] = $_POST['email'];
    $user['address'] = $_POST['address'];
    $user['country'] = $_POST['country'];
    $user['password'] = $_POST['password']; // se encripta en saveUser, si se encripta acá también hace una doble encript. y falla
    $user['isAdmin'] = 0; // Amigo

    // Llama a la función para verificar si el correo ya existe
    if (emailExists($user['email'])) {
        // Si el correo ya existe, redirige a la página de error de registro
        header("Location: /signup_error.php");
        exit();
    }

    // Si el correo es único, guardar el usuario
    if (saveUser($user)) {
        header("Location: /login.php"); // Redirige al login después del registro
        exit();
    } else {
        header("Location: /signup.php?error=Invalid user data"); // Redirige si hay un error en el registro
        exit();
    }
}
?>
