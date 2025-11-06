<?php
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline'; frame-ancestors 'none'; base-uri 'self';");
$hostname = getenv("HOSTNAME");
$username = getenv("USER");
$password = getenv("PASSWORD");
$db = getenv("DB");
$conn = new mysqli($hostname, $username, $password, $db);
$email = isset($_GET['user']) ? $_GET['user'] : '';

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// --- Construir la consulta directamente (INSEGURO) ---
$sql = "
    SELECT
        ce.nombre AS nombre_cerdo,
        ca.nombre AS nombre_carrera,
        ca.fecha AS fecha_carrera,
        ap.cantidad AS cantidad_apostada,
        ap.id AS id_apuesta,
        ap.cerdo AS id_cerdo,
        ap.idCarrera AS id_carrera,
        us.nombre AS nombre_usuario
    FROM
        apuesta ap
    JOIN cerdo ce ON ap.cerdo = ce.id
    JOIN carrera ca ON ap.idCarrera = ca.id
    JOIN usuarios us ON ap.idUs = us.id
    ORDER BY ap.idCarrera ASC
";

$result = $conn->query($sql);

if ($result === false) {
    echo "Error en la consulta: " . $conn->error;
} else {
    echo "<title>Los MontaMarcos - Mostrar apuestas</title>";
    echo "<style>

            .fila {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }

            .container {
                text-align: center;
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                max-width: 400px;
                width: 100%;
            }

            .volver-container {
                position: absolute;
                top: 10px;
                right: 20px;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                font-family: Arial, sans-serif;
                font-size: 16px;
                color: #333;
                gap: 5px;
            }

            .volver-container a {
                background: #4CAF50;
                color: white;
                padding: 8px 16px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                transition: background 0.3s ease;
            }

            .volver-container a:hover {
                background: #45a049;
            }

          </style>";
    echo "<body>";
    echo "<div class='fila'>";
    if ($result->num_rows === 0) {
    echo "<p style='text-align:center; font-family:Arial; font-size:18px; color:#555; margin-top:50px;'>
            No hay apuestas registradas actualmente.
          </p>";
    }
    else{
        while ($row = $result->fetch_assoc()) {
            echo "<div class='container'>";
            echo "<h3><strong> Apuesta número " . $row['id_apuesta'] . "</strong></h3>";
            echo "Usuario: " . $row['nombre_usuario'] . "<br>";
            echo "Cerdo número " . $row['id_cerdo'] . ": " . $row['nombre_cerdo'] . "<br>";
            echo "Carrera número " . $row['id_carrera'] . ": " . $row['nombre_carrera'] . "<br>";
            echo "Fecha: " . $row['fecha_carrera'] . "<br>";
            echo "Cantidad apostada: " . $row['cantidad_apostada'] . "<br><br>";
            echo "</div>";
            $contador++; // Incrementa el contador
        }
    }
    echo "<div class='volver-container'>";
    echo "<a href=" . "/items/items.php?user=" . urlencode($email) . ">Volver</a>";
    echo "</div>";
    echo "</body>";
}

$conn->close();
?>
