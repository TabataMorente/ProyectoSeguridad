<?php
include('../auth.php');

	$nombre = "null";
        $email = "null";
        
        
        
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
