<?php
        $id_usuario = -1;
	$lista_apuestas = null;

        if ( $_SERVER['REQUEST_METHOD'] === "GET")
        {
                if ( isset($_GET["user"]) )
                {
                        // Esto es para acceder al nombre
                        $hostname = "db";
                        $username = "admin";
                        $password = "test";
                        $db = "database";

                        $conn = mysqli_connect($hostname,$username,$password,$db);

                        if ($conn->connect_error) {
                                die("Database connection failed: " . $conn->connect_error);
                        }

                        $comando = "SELECT `id` FROM `usuarios` WHERE `email`='" . $_GET["user"] . "';";
                        $query = mysqli_query($conn, $comando) or die (mysqli_error($conn));

			if ($row = mysqli_fetch_array($query))
                        {
                                $id_usuario = $row["id"];
                        }

			if ( $id_usuario != -1 )
			{
				$comando = "SELECT * FROM `apuesta` WHERE `idUs`=" . "'" . $id_usuario . "'" . ";";
                        	$query = mysqli_query($conn, $comando) or die (mysqli_error($conn));

				$lista_apuestas = [];
				$current_index = 0;

				while ( $row = mysqli_fetch_array($query) )
				{
					$lista_apuestas[$current_index] = $row;
					$current_index += 1;
				}
			}

                        $conn->close();
                }
        }

        include "index.html";
?>
