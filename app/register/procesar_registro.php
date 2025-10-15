<?php
require_once "conexion.php"; // asume que conexion.php define $conn (mysqli)

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    exit;
}

// --- Tomar los datos tal cual vienen del formulario (SIN VALIDAR) ---
$nombre   = isset($_POST['nombre'])   ? $_POST['nombre']   : '';
$dni      = isset($_POST['dni'])      ? $_POST['dni']      : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
$fecha    = isset($_POST['fecha'])    ? $_POST['fecha']    : '';
$email    = isset($_POST['email'])    ? $_POST['email']    : '';

// --- Construir la consulta directamente (muy INSEGURO) ---
$sql = "INSERT INTO usuarios (nombre, dni, telefono, fecha, email)
        VALUES ('$nombre', '$dni', '$telefono', '$fecha', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Registro completado correctamente (inseguro).";
} else {
    // En un entorno real no deberías mostrar $conn->error a usuarios finales
    echo "❌ Error al insertar: " . $conn->error;
}

$conn->close();
?>
