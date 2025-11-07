<?php
include('../auth.php');
// modify_datos.php

$hostname = getenv("HOSTNAME");
$username = getenv("USER");
$password = getenv("PASSWORD");
$db = getenv("DB");

$conn = new mysqli($hostname, $username, $password, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    exit;
}

// Recoger y sanear
$nombre        = trim($_POST['nombre'] ?? '');
$dni           = trim($_POST['dni'] ?? '');
$telefono      = trim($_POST['telefono'] ?? '');
$fecha         = trim($_POST['fecha'] ?? '');
$email_original= trim($_POST['email'] ?? '');    //con session solo el usuario original puede modificar sus datos     // hidden original email (identificador)
$email_nuevo   = trim($_POST['email_visible'] ?? ''); // email editable por el usuario
$con_actual    = $_POST['contrasena_actual'] ?? '';
$con_nueva     = $_POST['contrasena_nueva'] ?? '';

$errors = [];

// Validaciones básicas
if ($nombre === '') $errors[] = "El nombre es obligatorio.";
if ($email_nuevo === '' || !filter_var($email_nuevo, FILTER_VALIDATE_EMAIL)) $errors[] = "Email no válido.";
if ($fecha !== '') {
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!($d && $d->format('Y-m-d') === $fecha)) $errors[] = "Formato de fecha inválido (esperado YYYY-MM-DD).";
}
if ($telefono !== '' && !preg_match('/^\+?\d{7,15}$/', $telefono)) $errors[] = "Teléfono inválido.";
if ($dni !== '' && !preg_match('/^[A-Za-z0-9\-]{4,20}$/', $dni)) $errors[] = "DNI inválido.";

// obtenemos hash actual del usuario (para verificar contraseña y obtener su id)
$stmt = $conn->prepare("SELECT id, contrasena FROM usuarios WHERE email = ? LIMIT 1");
if (!$stmt) {
    error_log("Prepare error (select user): " . $conn->error);
    echo "Error interno.";
    exit;
}
$stmt->bind_param("s", $email_original);
$stmt->execute();
$res = $stmt->get_result();

if (!($row = $res->fetch_assoc())) {
    $stmt->close();
    $conn->close();
    echo "Usuario no encontrado.";
    exit;
}
$user_id = $row['id'];
$hash_guardado_en_bd = $row['contrasena'];
$stmt->close();

// Verificar contraseña actual
if (!password_verify($con_actual, $hash_guardado_en_bd)) {
    $errors[] = "La contraseña actual es incorrecta.";
}

// Si se ha pedido nueva contraseña, validar longitud
$change_password = false;
if (strlen($con_nueva) > 0) {
    if (strlen($con_nueva) < 8) {
        $errors[] = "La nueva contraseña debe tener al menos 8 caracteres.";
    } else {
        $change_password = true;
        $new_hash = password_hash($con_nueva, PASSWORD_DEFAULT);
        if ($new_hash === false) {
            $errors[] = "Error al generar el hash de la nueva contraseña.";
        }
    }
}

if (!empty($errors)) {
    foreach ($errors as $err) echo htmlspecialchars("• $err") . "<br>";
    echo "<div class='volver-container'><a href='modify_user.php?user=" . urlencode($email_original) . "'>Volver</a></div>";
    $conn->close();
    exit;
}

// Comprobar duplicados de email o DNI pero excluyendo al propio usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE (email = ? OR dni = ?) AND id <> ? LIMIT 1");
if (!$stmt) {
    error_log("Prepare error (check duplicates): " . $conn->error);
    echo "Error interno.";
    exit;
}
$stmt->bind_param("ssi", $email_nuevo, $dni, $user_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "El email o DNI ya está registrado por otro usuario.";
    echo "<div class='volver-container'><a href='modify_user.php?user=" . urlencode($email_original) . "'>Volver</a></div>";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Preparar UPDATE dinámico según si cambia la contraseña o no
if ($change_password) {
    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, dni = ?, telefono = ?, fecha = ?, email = ?, contrasena = ? WHERE id = ?");
    if (!$stmt) { error_log("Prepare error (update w/pass): ".$conn->error); echo "Error interno."; exit; }
    $stmt->bind_param("ssssssi", $nombre, $dni, $telefono, $fecha, $email_nuevo, $new_hash, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, dni = ?, telefono = ?, fecha = ?, email = ? WHERE id = ?");
    if (!$stmt) { error_log("Prepare error (update): ".$conn->error); echo "Error interno."; exit; }
    $stmt->bind_param("sssssi", $nombre, $dni, $telefono, $fecha, $email_nuevo, $user_id);
}

if ($stmt->execute()) {
    echo "✅ Datos modificados correctamente.";
    echo "<div class='volver-container'><a href='modify_user.php?user=" . urlencode($email_nuevo) . "'>Volver al perfil</a></div>";
} else {
    error_log("Execute error (update): " . $stmt->error);
    echo "❌ Error al modificar los datos. Inténtalo más tarde.";
    echo "<div class='volver-container'><a href='modify_user.php?user=" . urlencode($email_original) . "'>Volver</a></div>";
}

$stmt->close();
$conn->close();
?>
