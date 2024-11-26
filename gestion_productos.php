<?php
session_start();

// Verifica si el usuario está autenticado y si es administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            color: #ff4500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #444;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #ff4500;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #333;
        }
        .btn {
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            background-color: #ff4500;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #e03e00;
        }
        .actions a {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Productos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_producto']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo number_format($row['precio'], 2); ?> MXN</td>
                            <td class="actions">
                                <a href="editar_producto.php?id=<?php echo $row['id_producto']; ?>" class="btn">Editar</a>
                                <a href="eliminar_producto.php?id=<?php echo $row['id_producto']; ?>" class="btn" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="formulario_producto.html" class="btn">Agregar Producto</a>
        <br><br>
        <a href="dashboard_admin.php" class="btn">Volver al Panel</a>
    </div>
</body>
</html>
