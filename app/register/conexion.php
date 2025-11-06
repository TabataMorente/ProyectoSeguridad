<?php

$hostname = getenv("HOSTNAME");
$username = getenv("USER");
$password = getenv("PASSWORD");
$db = getenv("DB");
$conn = new mysqli($hostname, $username, $password, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
