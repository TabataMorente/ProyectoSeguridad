<?php
session_start(); //inicia sesion para poder guardar los datos
$inactividad_max = 60*30;

if (isset($_SESSION['ultimo_acceso'])) {
    if (time() - $_SESSION['ultimo_acceso'] > $inactividad_max) {
        session_unset();
        session_destroy();
        header("Location: /index.html?error=session_expirada");
        exit;
    }
}
$_SESSION['ultimo_acceso'] = time();

	$nombre = "null";
        $email = "null";

        //Verificar si hay sesion activa
        if(!isset($_SESSION['email']))
        {
                header("Location: /index.html?error=acceso_no_autorizado");
                exit;
        }
        //Verificar que hay parametro GET y que coincida con la sesion
        if (!isset($_GET['user']) || $_GET['user'] !== $_SESSION['email']) {
                echo "No tienes permiso para acceder a esta página.";
                exit;
        }
                // Esto es para acceder al nombre
        	$hostname = getenv("HOSTNAME");
		$username = getenv("USER");
		$password = getenv("PASSWORD");
		$db = getenv("DB");

		$conn = new mysqli($hostname, $username, $password, $db);
                if ($conn->connect_error)
                {
                        die("Database connection failed: " . $conn->connect_error);
                }
               

        //Evitar inyeccion SQL
        $stmt = $conn->prepare("SELECT nombre FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result -> fetch_assoc())
        {
                $nombre = $row["nombre"];
                $email = $_SESSION["email"];
        }

        $stmt->close();
        $conn->close();

        
        

        include "index.html";
?>
