<?php
    include('utils/functions.php');

    session_start();
// Connect to bd
    $conn = getConnection();
    $sql = "SELECT * FROM users";
    $users = mysqli_query($conn, $sql);

    if (isset($_SESSION['success_message'])) {
        echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
        unset($_SESSION['success_message']);
    }

    if (isset($_SESSION['warning_message'])) {
        echo "<div class='warning-message'>" . $_SESSION['warning_message'] . "</div>";
        unset($_SESSION['warning_message']);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
</head>
<body>
    <h1>Administración de Usuarios</h1>
    
    <form method="post" action="actions/process.php">
    <table>
        <tr>
            <th>Seleccionar</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Provincia</th>
            <th>Password</th>
        </tr>
        <?php foreach ($users as $user) : ?>
        <tr>
            <td><input type="checkbox" name="users[<?= $user['id'] ?>][checkbox]"></td>
            <td><input type="text" name="users[<?= $user['id'] ?>][firstname]" value="<?= $user['firstname'] ?>"></td>
            <td><input type="text" name="users[<?= $user['id'] ?>][lastname]" value="<?= $user['lastname'] ?>"></td>
            <td><input type="text" name="users[<?= $user['id'] ?>][username]" value="<?= $user['username'] ?>"></td>
            <td><input type="text" name="users[<?= $user['id'] ?>][province_id]" value="<?= $user['province_id'] ?>"></td>
            <td><input type="password" name="users[<?= $user['id'] ?>][password]"></td>
            <input type="hidden" name="users[<?= $user['id'] ?>][id]" value="<?= $user['id'] ?>">
        </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" value="Update" name="update">
    <input type="submit" value="Delete" name="delete">
    <input type="submit" value="Exit" name="exit">
</form>

</body>
</html>
