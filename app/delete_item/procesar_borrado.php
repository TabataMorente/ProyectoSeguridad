<?php
$host = "proyectoseguridad-db-1";
$usuario = "admin";
$clave = "test";
$bd = "database";

$conn = new mysqli($host, $usuario, $clave, $bd);
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
    exit;
}

$email = $_POST['user'] ?? null;
$sql_usuario = "SELECT id FROM usuarios WHERE email = '$email'";
$result_usuario = $conn->query($sql_usuario);
if (!$result_usuario || $result_usuario->num_rows === 0) {
    echo "❌ Usuario no encontrado.";
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
    exit;
}
$idUs = $result_usuario->fetch_assoc()['id'];

$idApuesta = isset($_POST['idApuesta']) ? $conn->real_escape_string($_POST['idApuesta']) : '';

if (empty($idApuesta)) {
    echo "❌ Faltan datos del formulario.";
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
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
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
    exit;
}

$sql_apuesta = "
    DELETE FROM apuesta WHERE id = '$idApuesta';
";

if ($conn->query($sql_apuesta) === TRUE) {
    echo "✅ Apuesta eliminada correctamente.";
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
} else {
    echo "❌ Error al eliminar la apuesta: " . $conn->error;
    echo "<a href=" . "/pagUsuario/pagUsuario.php?user=" . $email . ">  Volver</a>";
}

$conn->close();
?>
