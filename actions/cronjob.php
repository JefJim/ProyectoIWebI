<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'project1';
$username = 'root';
$password = '';

// Crear la conexión con MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar si la conexión tuvo éxito
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
$sql = "
SELECT arboles.id AS arbol_id, arboles.last_update, usuarios.nombre AS usuario_nombre
    FROM arboles
    INNER JOIN usuarios ON arboles.userId = usuarios.id
    WHERE arboles.last_update < DATE_SUB(NOW(), INTERVAL 1 MONTH)";

$result = $conn->query($sql);
$mensaje;
// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Construir el mensaje del correo
    $mensaje = "Los siguientes árboles no han sido actualizados desde hace 1 mes:\n\n";
    while ($arbol = $result->fetch_assoc()) {
        $mensaje .= "-ID " . $arbol['arbol_id'] . " (Última actualización: " . $arbol['last_update'] . ")\n";
        // Configuración del correo
    $para = "jefryjimenez2011@gmail.com";  // Correo del administrador
    $asunto = "Árboles desactualizados";
    $headers = "From: notificaciones@gmail.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";
        // Enviar el correo
        if (mail($para, $asunto, $mensaje, $headers)) {
            echo "Correo enviado correctamente.";
        } else {
            echo "Error al enviar el correo.";
        }
    }
} else {
    echo "No hay árboles desactualizados.";
}

// Cerrar la conexión
$conn->close();
?>
    