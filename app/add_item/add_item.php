<?php
include('../auth.php');

        $nombre = "null";
        $email = "null";

        if ( $_SERVER['REQUEST_METHOD'] === "GET")
        {
                if ( isset($_GET["user"]) )
                {
                        // Esto es para acceder al nombre
        
			$hostname = getenv("HOSTNAME");
			$username = getenv("USER");
			$password = getenv("PASSWORD");
			$db = getenv("DB");

                        $conn = mysqli_connect($hostname,$username,$password,$db);

                        if ($conn->connect_error) {
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

                        $conn->close();
                }
        }

        include "index.html";
?>
