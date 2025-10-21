<?php
$host = "proyectoseguridad-db-1";
$usuario = "admin";
$clave = "test";
$bd = "database";

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
$idCarrera = isset($_POST['idCarrera']) ? $conn->real_escape_string($_POST['idCarrera']) : '';
$cantidad  = isset($_POST['cantidad'])  ? $conn->real_escape_string($_POST['cantidad'])  : '';

if (empty($cerdo) || empty($idCarrera) || empty($cantidad)) {
    echo "❌ Faltan datos del formulario.";
    echo "<a href=" . "/items/items.php?user=" . $email . ">  Volver</a>";
    exit;
}

// Validar que el cerdo participa en la carrera
$sql_validacion = "
    SELECT 1 
    FROM participante 
    WHERE cerdo = '$cerdo' AND idCarrera = '$idCarrera'
";
$result_validacion = $conn->query($sql_validacion);

if (!$result_validacion || $result_validacion->num_rows === 0) {
    echo "❌ Error: El cerdo no participa en la carrera seleccionada.";
    echo "<a href=" . "/items/items.php?user=" . $email . ">  Volver</a>";
    exit;
}

$sql_apuesta = "
    INSERT INTO apuesta (cerdo, idCarrera, idUs, cantidad)
    VALUES ('$cerdo', '$idCarrera', '$idUs', '$cantidad')
";

if ($conn->query($sql_apuesta) === TRUE) {
    echo "✅ Apuesta registrada correctamente.";
    echo "<a href=" . "/items/items.php?user=" . $email . ">  Volver</a>";
} else {
    echo "❌ Error al registrar la apuesta: " . $conn->error;
    echo "<a href=" . "/items/items.php?user=" . $email . ">  Volver</a>";
}

$conn->close();
?>
