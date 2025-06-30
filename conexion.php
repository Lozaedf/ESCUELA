<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // sin contraseña por defecto en XAMPP
$base_de_datos = "escuela"; // reemplazá con el nombre real de tu base

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// El "echo 'Conexión exitosa';" ha sido removido.
?>