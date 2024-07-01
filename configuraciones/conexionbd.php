<?php
$servername = "localhost"; // Dirección del servidor MySQL
$username = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL
$dbname = "restaurantmagnament"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>
