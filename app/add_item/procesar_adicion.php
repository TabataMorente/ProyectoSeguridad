<?php

include '../conexion_bd/conexion_bd.php';
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline'; frame-ancestors 'none'; base-uri 'self';");
$host = $conexion_bd[0];
$usuario = $conexion_bd[1];
$clave = $conexion_bd[2];
$bd = $conexion_bd[3];

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

$conn = new mysqli($host, $usuario, $clave, $bd);
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    exit;
}

$email = $_POST['user'] ?? null;


$sql_usuario = "SELECT id FROM usuarios WHERE email = '$email'";
$result_usuario = $conn->query($sql_usuario);
if (!$result_usuario || $result_usuario->num_rows === 0) {
    echo "❌ Usuario no encontrado.";
    exit;
}
$idUs = $result_usuario->fetch_assoc()['id'];

$cerdo     = isset($_POST['cerdo'])     ? $conn->real_escape_string($_POST['cerdo'])     : '';
$carrera = isset($_POST['carrera']) ? $conn->real_escape_string($_POST['carrera']) : '';
$cantidad  = isset($_POST['cantidad'])  ? $conn->real_escape_string($_POST['cantidad'])  : '';

if (empty($cerdo) || !preg_match('/^[a-zA-Z0-9\s]{1,50}$/', $cerdo)) {
    echo "❌ El nombre del cerdo no es válido (solo letras, números y espacios, máx 50 caracteres).";
    exit;
}

if (empty($carrera) || !preg_match('/^[a-zA-Z0-9\s]{1,50}$/', $carrera)) {
    echo "❌ El nombre de la carrera no es válido (solo letras, números y espacios, máx 50 caracteres).";
    exit;
}

if (empty($cantidad) || !ctype_digit($cantidad) || (int)$cantidad <= 0) {
    echo "❌ La cantidad debe ser un número entero positivo.";
    exit;
}

// ---- Validar que el cerdo participa en la carrera ----
$stmt_validacion = $conn->prepare("SELECT 1 FROM participante WHERE cerdo = ? AND idCarrera = ?");
$stmt_validacion->bind_param("ss", $cerdo, $carrera);
$stmt_validacion->execute();
$result_validacion = $stmt_validacion->get_result();

if ($result_validacion->num_rows === 0) {
    echo "❌ Error: El cerdo no participa en la carrera seleccionada.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "add_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
    $stmt_validacion->close();
    $conn->close();
    exit;
}
$stmt_validacion->close();

$stmt_apuesta = $conn->prepare("INSERT INTO apuesta (cerdo, idCarrera, idUs, cantidad) VALUES (?, ?, ?, ?)");
$stmt_apuesta->bind_param("ssii", $cerdo, $carrera, $idUs, $cantidad);

if ($stmt_apuesta->execute()) {
    echo "✅ Apuesta registrada correctamente.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "add_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
} else {
    echo "❌ Error al registrar la apuesta: " . $stmt_apuesta->error;
    echo "<div class='volver-container'>";
    echo "<a href=" . "add_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
}

$stmt_apuesta->close();
$conn->close();
?>
