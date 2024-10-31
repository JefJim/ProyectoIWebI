<?php
function getspecies()
{
    $conn = getConnection(); // Get connection
    $result = $conn->query("SELECT id, name_trade, name_scientific FROM species"); // Query to get all species
    return $result->fetch_all(MYSQLI_ASSOC); // Return all species as an associative array
}

function getConnection(): bool|mysqli
{
    $connection = mysqli_connect('localhost', 'root', 'duke', 'project1');
    print_r(mysqli_connect_error());
    return $connection;
}
function saveUser($user): bool
{
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
    $password = md5($user['password']); // encrypt the password
    $role_id = 0; // friend

    // Insert the user into the database
    $sql = "INSERT INTO users (name, last_name, phone, email, address, country, passwd, isAdmin) 
            VALUES ('$firstname', '$lastname', '$phone', '$email', '$address', '$country', '$password', $role_id)";

    // Ejecutar
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn); // close connection
        return true;
    } else {
        error_log("Error: " . $sql . " - " . mysqli_error($conn)); // manage the error
        mysqli_close($conn); // Close the connection
        return false;
    }
}

function emailExists($email): bool
{
    $conn = getConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the email already exists in the database
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    $exists = $result->num_rows > 0; // Check if the email exists

    $conn->close(); // Close the connection

    return $exists; // return true if the email exists or false if it doesn't
}


function authenticate($email, $passwd): bool|array|null
{
    $conn = getConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $passwd = md5($passwd); // encrypt the password
    $sql = "SELECT * FROM users WHERE email = '$email' AND passwd = '$passwd'";
    $result = $conn->query($sql);

    // check if the user exists
    if (!$result) {
        error_log("SQL Error: " . mysqli_error($conn)); // manage the error
        return null;
    }

    $user = $result->fetch_assoc();

    $conn->close();

    return $user ? $user : null; // return the user if it exists or null if it doesn't
}
