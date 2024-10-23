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
    $connection = mysqli_connect('localhost', 'root', '', 'project1');
    print_r(mysqli_connect_error());
    return $connection;
}
function saveUser($user): bool {
    $conn = getConnection();
  
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
  
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $phone = $user['phone'];
    $email = $user['email'];
    $address = $user['address'];
    $country = $user['country'];
    $password = md5($user['password']); // Encriptar la contraseña aquí
    $role_id = 0; // Usuario normal
  
    // Insertar el usuario
    $sql = "INSERT INTO usuarios (nombre, apellido, telefono, email, direccion, pais, passwd, isAdmin) 
            VALUES ('$firstname', '$lastname', '$phone', '$email', '$address', '$country', '$password', $role_id)";
  
    // Ejecutar
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn); // Cerrar la conexión
        return true;
    } else {
        error_log("Error: " . $sql . " - " . mysqli_error($conn)); // Log del error en lugar de mostrarlo
        mysqli_close($conn); // Cerrar la conexión
        return false;
    }
  }  

  function emailExists($email): bool {
    $conn = getConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Consulta para verificar si el correo ya existe
    $sql = "SELECT id FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    $exists = $result->num_rows > 0; // Verifica si se encontró un resultado

    $conn->close(); // Cierra la conexión

    return $exists; // Retorna true si el correo ya existe, de lo contrario false
}


function authenticate($email, $passwd): bool|array|null {
    $conn = getConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $passwd = md5($passwd); // Encriptar la contraseña
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND passwd = '$passwd'";
    $result = $conn->query($sql);

    // Verifica si la consulta fue exitosa
    if (!$result) {
        error_log("SQL Error: " . mysqli_error($conn)); // Log del error en lugar de mostrarlo
        return null;
    }

    $user = $result->fetch_assoc();

    $conn->close();

    return $user ? $user : null; // Retorna el usuario si se encuentra
}
