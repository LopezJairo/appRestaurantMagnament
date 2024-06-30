<?php
$servername = "localhost"; // Dirección del servidor MySQL
$username = "tu_usuario"; // Usuario de MySQL
$password = "tu_contraseña"; // Contraseña de MySQL
$dbname = "restaurantemagnament"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM Usuarios WHERE username = ? AND password = MD5(?)";
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
