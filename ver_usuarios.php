<?php
include('conexion.php');

// Consulta para obtener los usuarios
$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #1a1a1a;
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px auto;
            width: 90%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #ff4500;
            color: white;
        }
        .btn-warning {
            background-color: #f0ad4e;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-warning:hover {
            background-color: #ec971f;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ff4500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #e03e00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_usuario']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['rol']; ?></td>
                            <td>
                                <a href="editar_usuario.php?id=<?php echo $row['id_usuario']; ?>" class="btn-warning">Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard_admin.php" class="btn">Volver al Panel</a>
    </div>
</body>
</html>
