<?php
// connect to the database
$host = 'localhost';
$dbname = 'project1';
$username = 'root';
$password = '';

// create the connection with MYSQL
$conn = new mysqli($host, $username, $password, $dbname);

// check the connection was successful
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}
$sql = "
SELECT trees.id AS tree_id, trees.last_update, users.name AS usuario_name
    FROM trees
    INNER JOIN users ON trees.userId = users.id
    WHERE trees.last_update < DATE_SUB(NOW(), INTERVAL 1 MONTH)";

$result = $conn->query($sql);
$mensaje;
// check if there are trees that have not been updated in the last month
if ($result->num_rows > 0) {
    // Create the message
    $mensaje = "The following trees have not been updated for 1 month:\n\n";
    while ($tree = $result->fetch_assoc()) {
        $mensaje .= "-ID " . $tree['tree_id'] . " (Last update: " . $tree['last_update'] . ")\n";
        // configuration of the email
    $para = "jefryjimenez2011@gmail.com";  // email address to send the notification
    $asunto = "Outdated trees";
    $headers = "From: notificaciones@gmail.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";
        // send the email
        if (mail($para, $asunto, $mensaje, $headers)) {
            echo "Email sent successfully.";
        } else {
            echo "Error sending email.";
        }
    }
} else {
    echo "There are no outdated trees.";
}

// Close the connection
$conn->close();
?>
    