<?php

        $nombre = "null";
        $email = "null";
        $dni = "null";
        $telefono = "null";
        $fecha = "null";
        $contrasena = "null";

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

                        $comando = "SELECT `nombre`,`dni`,`telefono`,`fecha`, `contrasena` FROM `usuarios` WHERE `email`='" . $_GET["user"] . "';";

                        $query = mysqli_query($conn, $comando) or die (mysqli_error($conn));

                        if ($row = mysqli_fetch_array($query))
                        {
                                $nombre = $row["nombre"];
                                $email = $_GET["user"];
                                $dni = $row["dni"];
                                $telefono = $row["telefono"];
                                $fecha = $row["fecha"];
                                $contrasena = $row["contrasena"];
                        }

                        $conn->close();
                }
        }

        include "index.html";
?>