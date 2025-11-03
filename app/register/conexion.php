<?php

include '../conexion_bd/conexion_bd.php';

$host = $conexion_bd[0];
$usuario= $conexion_bd[1];
$clave = $conexion_bd[2];
$bd = $conexion_bd[3];
$conn = new mysqli($host, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
