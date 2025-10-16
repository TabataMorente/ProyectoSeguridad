<?php
	$problema = true;

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// The request is using the POST method

		$hostname = "db";
		$username = "admin";
		$password = "test";
		$db = "database";

		$conn = mysqli_connect($hostname,$username,$password,$db);

		$nombre = $_POST["nombre"];
		$contrasena = $_POST["contrasena"];
		
		if ($conn->connect_error) {
			die("Database connection failed: " . $conn->connect_error);
		}

		$comando = "SELECT (`nombre`, `contrasena`) FROM `usuarios` WHERE `nombre`=" . $nombre . ";";

		$query = mysqli_query($conn, $comando) or die (mysqli_error($conn));

		echo $query;

		$problema = false;

	}

	if ( $problema )
	{
		echo "Hubo un problema al registrar la base de datos";
	}

?>
