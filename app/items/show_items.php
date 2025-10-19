<?php
$host = "proyectoseguridad-db-1";
$usuario = "admin";
$clave = "test";
$bd = "database";

$conn = new mysqli($host, $usuario, $clave, $bd);

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
        ap.idCarrera AS id_carrera
    FROM
        apuesta ap
    JOIN cerdo ce ON ap.cerdo = ce.id
    JOIN carrera ca ON ap.idCarrera = ca.id
    WHERE
        ap.idUs = (SELECT id FROM usuarios WHERE email = '" . $conn->real_escape_string($_GET['user']) . "')
";

$result = $conn->query($sql);

if ($result === false) {
    echo "Error en la consulta: " . $conn->error;
} else {

    while ($row = $result->fetch_assoc()) {
        echo "<strong> Apuesta número " . $row['id_apuesta'] . "</strong><br>";
        echo "Cerdo número " . $row['id_cerdo'] . ": " . $row['nombre_cerdo'] . "<br>";
        echo "Carrera número " . $row['id_carrera'] . ": " . $row['nombre_carrera'] . "<br>";
        echo "Fecha: " . $row['fecha_carrera'] . "<br>";
        echo "Cantidad apostada: " . $row['cantidad_apostada'] . "<br><br>";
        $contador++; // Incrementa el contador
    }
}

$conn->close();
?>
