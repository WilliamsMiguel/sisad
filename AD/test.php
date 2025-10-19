<?php
// test_db_connection.php

$servidor = "localhost";
$usuario = "root";  // Cambia según sea necesario
$clave = "";  // Cambia según sea necesario
$baseDeDatos = "sisadbd";

$conexion = new mysqli($servidor, $usuario, $clave, $baseDeDatos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

echo "Conexión exitosa";
$conexion->close();
?>
