<?php
	include '../conexion_bd/conexion_bd.php';
	$problema = true;

	if ($_SERVER['REQUEST_METHOD'] === 'GET')
	{
		if ( isset($_GET["email"]) and isset($_GET["contrasena"])  )
		{
			// The request is using the POST method

			$hostname = $conexion_bd[0];
			$username = $conexion_bd[1];
			$password = $conexion_bd[2];
			$db = $conexion_bd[3];

			$conn = mysqli_connect($hostname,$username,$password,$db);
		
			if ($conn->connect_error) {
				die("Database connection failed: " . $conn->connect_error);
			}
		
			$email = trim($_GET["email"]);
        	$contrasena = $_GET["contrasena"];

			//if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //echo "❌ Formato de correo inválido.";
            //exit;
        	//}
	
			$stmt_validacion = $conn->prepare("SELECT `email`, `contrasena` FROM `usuarios` WHERE `email` = ?");
			$stmt_validacion->bind_param("s", $email);
			$stmt_validacion->execute();

			$query = $stmt_validacion->get_result();
			
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
			$conn->close();
			exit;	
		}

		if ( $problema )
		{
			echo "Hubo un problema al consultar la base de datos";
		}
	}

?>
