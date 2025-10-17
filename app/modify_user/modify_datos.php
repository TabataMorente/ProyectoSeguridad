<?php
$host = "proyectoseguridad-db-1";
$usuario = "admin";
$clave = "test";
$bd = "database";

$conn = new mysqli($host, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

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
$emailAnt = isset($_GET['user'])    ? $_GET['user']    : '';

// --- Construir la consulta directamente (muy INSEGURO) ---
$sql = "UPDATE usuarios
        SET nombre = '$nombre',
        contrasena = '$contrasena',
        dni = '$dni',
        telefono = '$telefono',
        fecha = '$fecha',
        email = '$email'
        WHERE email ='$emailAnt';";
// echo $sql;


if ($conn->query($sql) === TRUE) {
    echo "✅ Modificacion completada correctamente (inseguro).";
    echo "<a href='../pagUsuario/pagUsuario.php?user=$email'>  Pagina principal</a>";
} else {
    // En un entorno real no deberías mostrar $conn->error a usuarios finales
    echo "❌ Error al insertar: " . $conn->error;
}

$conn->close();
?>
