<?php
echo " 
    <style>
    .volver-container {
      position: absolute;
      top: 10px;
      right: 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      font-family: Arial, sans-serif;
      font-size: 16px;
      color: #333;
      gap: 5px;
    }

    .volver-container a {
      background: #4CAF50;
      color: white;
      padding: 8px 16px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .volver-container a:hover {
      background: #45a049;
    }
    </style>";
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
$contrasena = isset($_POST['contrasena'])    ? $_POST['contrasena']    : '';

// --- Construir la consulta directamente (muy INSEGURO) ---
$sql = "INSERT INTO usuarios (nombre, contrasena, dni, telefono, fecha, email)
        VALUES ('$nombre', '$contrasena','$dni', '$telefono', '$fecha', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Registro completado correctamente (inseguro).";
    echo "<div class='volver-container'>";
    echo "<a href='../login/index.html'>  Iniciar sesión </a>";
    echo "</div>";
} else {
    // En un entorno real no deberías mostrar $conn->error a usuarios finales
    echo "❌ Error al insertar: " . $conn->error;
    echo "<div class='volver-container'>";
    echo "<a href='index.html'>  Volver</a>";
    echo "</div>";}

$conn->close();
?>
