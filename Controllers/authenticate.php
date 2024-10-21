<?php
session_start();

// Incluir la conexión a la base de datos
include_once 'Models/Database.php';

// Obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Obtener los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Buscar el usuario en la base de datos por su correo electrónico
$query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario existe y si la contraseña es correcta (sin hashing)
if ($user && $password === $user['password']) {
    // Guardar los datos del usuario en la sesión
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['nombre'];
    $_SESSION['user_role'] = $user['rol'];
    
    // Redirigir al usuario a la página principal
    header("Location: index.php?page=Principal");
    exit();
} else {
    // Si las credenciales son incorrectas
    echo "Credenciales incorrectas. Por favor, intenta nuevamente.";
}
