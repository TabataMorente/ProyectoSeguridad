<?php
	$problema = true;

	if ($_SERVER['REQUEST_METHOD'] === 'GET')
	{
		if ( isset($_GET["email"]) and isset($_GET["contrasena"])  )
		{
			// The request is using the POST method

			$hostname = "db";
			$username = "admin";
			$password = "test";
			$db = "database";

			$conn = mysqli_connect($hostname,$username,$password,$db);
		
			if ($conn->connect_error) {
				die("Database connection failed: " . $conn->connect_error);
			}
		
			$email = $_GET["email"];
			$contrasena = $_GET["contrasena"];
	
			$comando = "SELECT `email`, `contrasena` FROM `usuarios` WHERE `email`='" . $email . "';";

			$query = mysqli_query($conn, $comando) or die (mysqli_error($conn));
			
			if ($row = mysqli_fetch_array($query))
			{
				if ( $row["contrasena"] == $contrasena )
				{
					header("Location:/pagUsuario/pagUsuario.php?user=" . urlencode($email));
				}
				else
				{
					header("Location:/login/index.html?error=2");
				}
			}
			else	
			{
				header("Location:/login/index.html?error=1");
			}
	
			$problema = false;
			$conn->close(); // Es recomendable cerrar la base de datos despues de usarla
			exit;	
		}

		if ( $problema )
		{
			echo "Hubo un problema al consultar la base de datos";
		}
	}

?>
