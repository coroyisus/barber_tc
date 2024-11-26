<?php
$servidor = "localhost";
$usuario = "root";
$password = ""; // Cambia esto si tienes contraseña en tu servidor MySQL
$base_datos = "barber_system";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres
$conexion->set_charset("utf8");
?>
