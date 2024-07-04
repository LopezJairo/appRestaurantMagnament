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
$nombre_cliente = $_POST['nombre_cliente'];
$email_cliente = $_POST['email_cliente'];
$contraseña = $_POST['contraseña'];

// Verificar que los datos fueron enviados
if (!isset($nombre_cliente) || !isset($email_cliente) || !isset($contraseña)) {
    echo "Por favor, complete todos los campos del formulario.";
    echo '<br><a href="registro.html">Volver</a>';
    exit();
}

// Verificar si el email ya está registrado
$sql_verificar = "SELECT * FROM Clientes WHERE email_cliente = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("s", $email_cliente);
$stmt_verificar->execute();
$result_verificar = $stmt_verificar->get_result();

if ($result_verificar->num_rows > 0) {
    echo "El email ya está registrado. Intente con otro email.";
    echo '<br><a href="registro.html">Volver</a>';
    exit();
}

// Insertar nuevo cliente en la tabla Clientes
$sql_insertar = "INSERT INTO Clientes (email_cliente, nombre_cliente, contraseña) VALUES (?, ?, MD5(?))";
$stmt_insertar = $conn->prepare($sql_insertar);
$stmt_insertar->bind_param("sss", $email_cliente, $nombre_cliente, $contraseña);

if ($stmt_insertar->execute()) {
    echo "Registro exitoso. Ahora puedes iniciar sesión.";
    header("Location: login.html");
    exit();
} else {
    echo "Error al registrar. Inténtelo nuevamente.";
    echo '<br><a href="registro.html">Volver</a>';
}

$stmt_insertar->close();
$conn->close();
?>
