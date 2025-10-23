<?php
$host = "proyectoseguridad-db-1";
$usuario = "admin";
$clave = "test";
$bd = "database";
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
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
    exit;
}

$email = $_POST['user'] ?? null;
$sql_usuario = "SELECT id FROM usuarios WHERE email = '$email'";
$result_usuario = $conn->query($sql_usuario);
if (!$result_usuario || $result_usuario->num_rows === 0) {
    echo "❌ Usuario no encontrado.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
    exit;
}
$idUs = $result_usuario->fetch_assoc()['id'];

$idApuesta = isset($_POST['idApuesta']) ? $conn->real_escape_string($_POST['idApuesta']) : '';

if (empty($idApuesta)) {
    echo "❌ Faltan datos del formulario.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
    exit;
}

// Validar que el cerdo participa en la carrera
$sql_validacion = "
    SELECT id
    FROM apuesta
    WHERE id = '$idApuesta'
";
$result_validacion = $conn->query($sql_validacion);

if (!$result_validacion || $result_validacion->num_rows === 0) {
    echo "❌ Error: La apuesta indicada no existe.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
    exit;
}

$sql_apuesta = "
    DELETE FROM apuesta WHERE id = '$idApuesta';
";

if ($conn->query($sql_apuesta) === TRUE) {
    echo "✅ Apuesta eliminada correctamente.";
    echo "<div class='volver-container'>";
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
} else {
    echo "❌ Error al eliminar la apuesta: " . $conn->error;
    echo "<div class='volver-container'>";
    echo "<a href=" . "delete_item.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
}

$conn->close();
?>
