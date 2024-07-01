<?php
$servername = "localhost"; // Dirección del servidor MySQL
$username = "root"; // Usuario de MySQL (cámbialo a tu usuario real)
$password = ""; // Contraseña de MySQL (cámbialo a tu contraseña real)
$dbname = "restaurantmagnament"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$email_cliente = $_POST['email_cliente'];
$contraseña = $_POST['contraseña'];

// Verificar que los datos fueron enviados
if (!isset($email_cliente) || !isset($contraseña)) {
    die("Por favor, complete el formulario.");
}

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM Clientes WHERE email_cliente = ? AND contraseña = MD5(?)";
$stmt = $conn->prepare($sql);


if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("ss", $email_cliente, $contraseña);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Login exitoso. Bienvenido, " . $email_cliente . "!";
} else {
    echo "Usuario o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>
