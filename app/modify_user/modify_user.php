<?php
include('../auth.php');
$nombre = $email = $dni = $telefono = $fecha = "";

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET["user"])) {
    
   $hostname = getenv("HOSTNAME");
   $username = getenv("USER");
   $password = getenv("PASSWORD");
   $db = getenv("DB");
   $conn = new mysqli($hostname, $username, $password, $db);
   
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $emailParam = $_GET["user"];

    $stmt = $conn->prepare("SELECT id, nombre, dni, telefono, fecha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $emailParam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $usuario_id = $row['id'];
        $nombre = $row["nombre"];
        $email = $emailParam;
        $dni = $row["dni"];
        $telefono = $row["telefono"];
        $fecha = $row["fecha"];
    } else {
        header("Location: ../login/index.html?error=4");
        exit;
    }

    $stmt->close();
    $conn->close();

    // Incluye el HTML que usa las variables $nombre, $email, ... (ver el fragmento de formulario abajo)
    include "index.html";
} else {
    header("Location: ../login/index.html?error=3");
    exit;
}
