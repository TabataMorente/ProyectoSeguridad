<?php
// modify_user.php

// --- 1. Conexión con la base de datos ---
$servername = "mysql";       // nombre del servicio en docker-compose.yml
$username = "root";          // cambia si usáis otro usuario
$password = "root";          // cambia si usáis otra contraseña
$database = "usuarios_db";   // cambia por el nombre real de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// --- 2. Recoger datos del formulario ---
$nombre = $_POST['nombre'] ?? '';
$dni = strtoupper($_POST['dni'] ?? '');
$telefono = $_POST['telefono'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$email = $_POST['email'] ?? '';

// Aquí suponemos que el usuario está identificado y tenemos su ID (p. ej. en sesión)
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Error: no hay sesión activa.";
    exit;
}

$user_id = $_SESSION['user_id'];

// --- 3. Validación simple ---
if (!preg_match("/^[0-9]{8}-[A-Z]$/", $dni)) {
    die("DNI no válido.");
}

if (!preg_match("/^[0-9]{9}$/", $telefono)) {
    die("Teléfono no válido.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email no válido.");
}

// --- 4. Actualizar datos ---
$sql = "UPDATE usuarios SET 
            nombre = ?, 
            dni = ?, 
            telefono = ?, 
            fecha_nacimiento = ?, 
            email = ?,
            contrasena = ?,
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $nombre, $dni, $telefono, $fecha, $email, $contrasena, $user_id);

if ($stmt->execute()) {
    echo "<h3>Datos actualizados correctamente ✅</h3>";
    echo "<a href='../index.html'>Volver al inicio</a>";
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

