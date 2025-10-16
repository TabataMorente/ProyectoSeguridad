<?php
	$problema = true;

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		// The request is using the POST method

		$hostname = "db";
		$username = "admin";
		$password = "test";
		$db = "database";

		$conn = mysqli_connect($hostname,$username,$password,$db);
		
		if ($conn->connect_error) {
			die("Database connection failed: " . $conn->connect_error);
		}
		
		$nombre = $_GET["nombre"];
		$contrasena = $_GET["contrasena"];

		$comando = "SELECT `email`, `contrasena` FROM `usuarios` WHERE `email`='" . $nombre . "';";

		$query = mysqli_query($conn, $comando) or die (mysqli_error($conn));
		
		if ($row = mysqli_fetch_array($query))
		{
			if ( $row["contrasena"] == $contrasena )
			{
				header("Location:/pagUsuario/pagUsuario.php?user=" . urlencode($nombre));
				exit;
			}
			else
			{
				header("Location:/login/login.html");
				exit;
			}
		}
		else
		{
			header("Location:/login/login.html");
			exit;
		}
		
		$problema = false;
		$conn->close(); // Es recomendable cerrar la base de datos despues de usarla
	}

	if ( $problema )
	{
		echo "Hubo un problema al consultar la base de datos";
	}

?>
