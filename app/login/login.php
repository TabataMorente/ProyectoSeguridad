<?php
//Mantener sesion activa durante 30 minutos
ini_set('session.cookie_lifetime',60*30); //Tiempo que dura la cookie de sesion en el navegador del usuario 
ini_set('session.gc_maxlifetime',60*30); //Tiempo que el servidor mantiene la sesion almacenada antes de eliminarla

session_start(); //inicia la sesion para poder guardar los datos del usuario


include "../conexion_bd/conexion_bd.php"; // ajusta la ruta a tu conexión

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Método no permitido.";
    exit;
}

$email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
$contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : '';

if (empty($email) || empty($contrasena)) {
    header("Location: index.html?error=3"); // campos vacíos
    exit;
}

// Conexión
$hostname = getenv("HOSTNAME");
$username = getenv("USER");
$password = getenv("PASSWORD");
$db = getenv("DB");
$conn = new mysqli($hostname, $username, $password, $db);

if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    echo "❌ Error interno. Inténtalo más tarde.";
    exit;
}

// Buscar usuario por email
$stmt = $conn->prepare("SELECT email, contrasena FROM usuarios WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Verificar la contraseña con hash
    if (password_verify($contrasena, $row["contrasena"])) {
        //Sesion segura
        session_regenerate_id(true);
        $_SESSION['email'] = $row['email']; //guardar quien ha iniciado sesion
        
        // Redirigir al usuario con su email en la URL
        header("Location: /pagUsuario/pagUsuario.php?user=" . urlencode($row["email"]));
        exit;
    } else {
        header("Location: index.html?error=2"); // contraseña incorrecta
        exit;
    }
} else {
    header("Location: index.html?error=1"); // usuario no encontrado
    exit;
}

$stmt->close();
$conn->close();
?>
