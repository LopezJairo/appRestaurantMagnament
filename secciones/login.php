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

// Obtener datos del formulario
$username = $_POST['email_cliente'];
$password = $_POST['contraseña'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM clientes WHERE email_cliente = ? AND password = MD5(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Login exitoso. Bienvenido, " . $username . "!";
} else {
    echo "Usuario o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>
