<?php
session_start();

// Verificar si la sesión está activa y si el usuario es administrador
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php'); // Redirigir al login si no está logueado
    exit;
}

// Incluir el archivo de conexión
require 'conexion.php';

// Obtener estadísticas de la base de datos
$query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
$query_citas = "SELECT COUNT(*) AS total_citas FROM citas";
$query_productos = "SELECT COUNT(*) AS total_productos FROM productos";

$result_usuarios = $conexion->query($query_usuarios);
$result_citas = $conexion->query($query_citas);
$result_productos = $conexion->query($query_productos);

$total_usuarios = ($result_usuarios && $result_usuarios->num_rows > 0) ? $result_usuarios->fetch_assoc()['total_usuarios'] : 0;
$total_citas = ($result_citas && $result_citas->num_rows > 0) ? $result_citas->fetch_assoc()['total_citas'] : 0;
$total_productos = ($result_productos && $result_productos->num_rows > 0) ? $result_productos->fetch_assoc()['total_productos'] : 0;

// Cerrar conexiones
$result_usuarios->free();
$result_citas->free();
$result_productos->free();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener un archivo de estilos -->
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #1e1e1e;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: orange;
            text-align: center;
        }
        .stat-box {
            display: flex;
            justify-content: space-between;
            background: #333;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border: 1px solid #444;
        }
        .stat-box span {
            font-size: 1.2rem;
        }
        .stat-box .value {
            font-weight: bold;
            font-size: 1.5rem;
            color: orange;
        }
        .btn-back {
            display: block;
            text-align: center;
            margin: 20px auto 0;
            padding: 10px 20px;
            background: orange;
            color: black;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: background 0.3s ease;
        }
        .btn-back:hover {
            background: #f90;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Estadísticas Generales</h1>
        <div class="stat-box">
            <span>Total de Usuarios:</span>
            <span class="value"><?php echo $total_usuarios; ?></span>
        </div>
        <div class="stat-box">
            <span>Total de Citas:</span>
            <span class="value"><?php echo $total_citas; ?></span>
        </div>
        <div class="stat-box">
            <span>Total de Productos:</span>
            <span class="value"><?php echo $total_productos; ?></span>
        </div>
        <a href="dashboard_admin.php" class="btn-back">Volver al Panel</a>
    </div>
</body>
</html>
