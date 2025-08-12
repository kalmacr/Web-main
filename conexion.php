<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "reciclaje";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa";
}
mysqli_set_charset($conn, 'utf8');

?>


