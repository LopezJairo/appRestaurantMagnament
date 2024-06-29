<?php
session_start();

// Parámetros de la conexión a la base de datos
$host = 'Jairo';
$db = 'restaurantemagnament';
$user = 'root';
$pass = '';

// Crear la conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta para evitar inyección de SQL
    $stmt = $conn->prepare("SELECT id, contraseña FROM Clientes WHERE nombre_usuario = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    
    // Verificar si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Iniciar sesión
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: bienvenido.php"); // Redirigir a una página de bienvenida
            exit();
        } else {
            $error = "La contraseña es incorrecta.";
        }
    } else {
        $error = "El nombre de usuario no existe.";
    }

    $stmt->close();
}

$conn->close();
?>
