<?php
include('../auth.php');
// Recuperar el usuario de la sesión
$email = $_SESSION['email'] ?? null;

if ($email) {
    header("Location: index.php?user=" . urlencode($email));
    exit;
} else {
    header("Location: /index.html?error=acceso_no_autorizado");
    exit;
}

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


//  Verificar token CSRF
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "❌ Solicitud no válida (token CSRF incorrecto o ausente).";
        echo "<div class='volver-container'>";
        echo "<a href='../index.html'>Volver</a>";
        echo "</div>";
        exit;
    }
}
?>