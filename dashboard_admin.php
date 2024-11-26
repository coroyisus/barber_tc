<?php
session_start();

// Verificar que el usuario es un administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        /* General */
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #292929;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #ff4500;
        }

        .header h1 {
            margin: 0;
            color: #ff4500;
        }

        .container {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            background-color: #333;
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            width: 280px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .card h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
        }

        .card p {
            margin: 10px 0;
        }

        .card a {
            text-decoration: none;
            color: white;
            background-color: #ff4500;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #e03e00;
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout a {
            text-decoration: none;
            color: white;
            background-color: #ff4500;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .logout a:hover {
            background-color: #e03e00;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenido, Administrador</h1>
    </div>

    <div class="container">
        <div class="card">
            <h3>Gestionar Usuarios</h3>
            <p>Visualiza y edita.</p>
            <a href="ver_usuarios.php">Ir a Usuarios</a>
        </div>
        <div class="card">
            <h3>Crear Administrador</h3>
            <p>Agrega un nuevo administrador al sistema.</p>
            <a href="crear_admin.php">Crear Admin</a>
        </div>
        <div class="card">
            <h3>Gestionar Productos</h3>
            <p>Administra los productos en la tienda.</p>
            <a href="gestion_productos.php">Ver Productos</a>
        </div>
        <div class="card">
            <h3>Gestionar Citas</h3>
            <p>Revisa las citas agendadas y su estado.</p>
            <a href="ver_citas.php">Ir a Citas</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>
