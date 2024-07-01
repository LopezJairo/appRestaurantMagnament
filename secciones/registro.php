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

// Variables para mensajes de error y éxito
$mensaje = "";
$error = false;

// Obtener datos del formulario
$nombre_cliente = $_POST['nombre_cliente'];
$email_cliente = $_POST['email_cliente'];
$contraseña = $_POST['contraseña'];

// Verificar que los datos fueron enviados
if (!isset($nombre_cliente) || !isset($email_cliente) || !isset($contraseña)) {
    die("Por favor, complete todos los campos del formulario.");
}

// Verificar si el email ya está registrado
$sql_verificar = "SELECT * FROM Clientes WHERE email_cliente = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("s", $email_cliente);
$stmt_verificar->execute();
$result_verificar = $stmt_verificar->get_result();

if ($result_verificar->num_rows > 0) {
    die("El email ya está registrado. Intente con otro email.");
}

// Insertar nuevo cliente en la tabla Clientes
$sql_insertar = "INSERT INTO Clientes (email_cliente, nombre_cliente, contraseña) VALUES (?, ?, MD5(?))";
$stmt_insertar = $conn->prepare($sql_insertar);
$stmt_insertar->bind_param("sss", $email_cliente, $nombre_cliente, $contraseña);

if ($stmt_insertar->execute()) {
    // Redirigir a la página de inicio de sesión
    header("Location: login.html");
    exit(); // Asegura que no se ejecute más código después de la redirección
} else {
    echo "Error al registrar. Inténtelo nuevamente.";
}

$stmt_insertar->close();
$conn->close();

// Si hay error, mostrar mensaje en la misma página
if ($error) {
    echo '<script>alert("' . $mensaje . '");</script>';
    echo '<script>window.history.go(-1);</script>';
}
?>
