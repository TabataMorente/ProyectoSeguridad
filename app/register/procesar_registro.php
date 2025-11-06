<?php
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline'; frame-ancestors 'none'; base-uri 'self';");
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

require_once "conexion.php"; // Debe definir $conn como mysqli

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido.";
    exit;
}

// --- Obtener y sanear entradas ---
$nombre           = trim($_POST['nombre']           ?? '');
$dni              = trim($_POST['dni']              ?? '');
$telefono         = trim($_POST['telefono']         ?? '');
$fecha            = trim($_POST['fecha']            ?? '');
$email            = trim($_POST['email']            ?? '');
$contrasena       = $_POST['contrasena']            ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena']      ?? '';

// --- Validaciones básicas ---
$errors = [];

if ($nombre === '') {
    $errors[] = "El nombre es obligatorio.";
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email no válido.";
}

if ($contrasena === '' || strlen($contrasena) < 8) {
    $errors[] = "La contraseña debe tener al menos 8 caracteres.";
}

if ($contrasena !== $confirmar_contrasena) {
    $errors[] = "Las contraseñas no coinciden.";
}

if ($fecha !== '') {
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!($d && $d->format('Y-m-d') === $fecha)) {
        $errors[] = "Formato de fecha inválido (esperado YYYY-MM-DD).";
    }
}

if ($telefono !== '' && !preg_match('/^\+?\d{7,15}$/', $telefono)) {
    $errors[] = "Teléfono inválido.";
}

if ($dni !== '' && !preg_match('/^[A-Za-z0-9\-]{4,20}$/', $dni)) {
    $errors[] = "DNI inválido.";
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo htmlspecialchars("• $err") . "<br>";
    }
    echo "<div class='volver-container'><a href='register.php'>Volver</a></div>";
    exit;
}

// --- Comprobar si email o dni ya existen ---
try {
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? OR dni = ? LIMIT 1");
    if (!$stmt) {
        error_log("Prepare error: " . $conn->error);
        throw new Exception("Error interno. Hubo un error al preparar la sentencia SQL");
    }

    $stmt->bind_param("ss", $email, $dni);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El email o DNI ya está registrado.";
        echo "<div class='volver-container'><a href='register.php'>Volver</a></div>";
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // --- Crear el hash de la contraseña ---
    $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
    if ($hashedPassword === false) {
        throw new Exception("No se pudo generar el hash de la contraseña.");
    }

    // --- Insertar usuario ---
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, contrasena, dni, telefono, email, fecha) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        error_log("Prepare error (insert): " . $conn->error);
        throw new Exception("Error interno. Inténtalo más tarde.");
    }

    $stmt->bind_param("ssssss", $nombre, $hashedPassword, $dni, $telefono, $email, $fecha);

    if ($stmt->execute()) {
        echo "✅ Registro completado correctamente.";
        echo "<div class='volver-container'><a href='../login/inicio.php'>Iniciar sesión</a></div>";
    } else {
        error_log("Execute error (insert): " . $stmt->error);
        echo "❌ Error al registrar el usuario. Inténtalo más tarde.";
        echo "<div class='volver-container'><a href='register.php'>Volver</a></div>";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    error_log("Exception en procesar_registro.php: " . $e->getMessage());
    echo "❌ waa.";
    echo "<div class='volver-container'><a href='register.php'>Volver</a></div>";
    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
    exit;
}
?>

