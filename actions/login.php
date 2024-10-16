<?php
require('../utils/functions.php');

if ($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // Llamada a la función de autenticación
    $user = authenticate($username, $password);

    if ($user) {
        session_start();

        $_SESSION['user'] = $user; // Almacena los datos del usuario en la sesión
        // Verifica el rol del usuario
        if ($user['isAdmin'] == 'Y') {
            header('Location: /admin.php'); // Redirige a la página de administrador
        } else {
            header('Location: /users.php'); // Redirige a la página de usuario estándar
        }
    } else {
        header('Location: /index.php?error=login'); // Redirige en caso de error en el login
    }
}
?>





