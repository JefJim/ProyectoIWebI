<?php

function getConnection(): bool|mysqli
{
    $connection = mysqli_connect('localhost', 'root', 'duke', 'project1');
    print_r(mysqli_connect_error());
    return $connection;
}

function authenticate($email, $passwd): bool|array|null
{
    $conn = getConnection();
    $passwd = md5($passwd);
    $sql = "SELECT * FROM usuarios WHERE `email` = '$email' AND `passwd` = '$passwd'";
    $result = $conn->query($sql);

    if ($conn->connect_errno) {
        $conn->close();
        return false;
    }

    $user = $result->fetch_assoc();  // Obtener los datos del usuario

    $conn->close();

    return $user ?: null;  // Si no hay usuario, devolver null
}
