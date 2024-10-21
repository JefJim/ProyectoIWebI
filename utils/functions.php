<?php
function getEspecies() {
    //select * from especies
    $conn = getConnection();
    $sql = "SELECT id, nombre_comercial FROM especies";
    $result = $conn->query($sql);
    return $result;
  }
function getConnection(): bool|mysqli
{
    $connection = mysqli_connect('localhost', 'root', 'duke', 'project1');
    print_r(mysqli_connect_error());
    return $connection;
}
function saveUser($user): bool{

    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $phone = $user['phone'];
    $email = $user['email'];
    $address = $user['address'];
    $country = $user['country'];
    $password = md5($user['password']);
    $role_id = 0; 
    $sql = "INSERT INTO usuarios (nombre, apellido, telefono, email, direccion, pais, passwd, isAdmin) VALUES('$firstname', '$lastname', '$phone', '$email', '$address', '$country', '$password', '$role_id')";
  
    try {
      $conn = getConnection();
      mysqli_query($conn, $sql);
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
    return true;
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
