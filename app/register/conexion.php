<?php
$host = "proyectoseguridad-db-1";
$usuario = "admin";
$clave = "test";
$bd = "database";

$conn = new mysqli($host, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
