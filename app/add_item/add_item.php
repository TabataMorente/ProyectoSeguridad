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

                        $comando = "SELECT `nombre` FROM `usuarios` WHERE `email`='" . $_GET["user"] . "';";
                        $query = mysqli_query($conn, $comando) or die (mysqli_error($conn));

                        if ($row = mysqli_fetch_array($query))
                        {
                                $nombre = $row["nombre"];
                                $email = $_GET["user"];
                        }

                        $conn->close();
                }
        }

        include "index.html";
?>
