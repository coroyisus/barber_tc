<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'conexion.php';

// Consulta para obtener las citas
$sql = "SELECT c.id_cita, c.fecha, c.hora, u.nombre AS cliente, c.estado FROM citas c JOIN usuarios u ON c.id_usuario = u.id_usuario ORDER BY c.fecha, c.hora";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ff4500;
            color: white;
        }
        td {
            background-color: #333333;
        }
        .btn {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #ff4500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn:hover {
            background-color: #e03e00;
        }
        select {
            background-color: #333333;
            color: white;
            border: 1px solid #ff4500;
            padding: 5px;
            border-radius: 5px;
        }
        .form-inline {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .form-inline button {
            background-color: #ff4500;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-inline button:hover {
            background-color: #e03e00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Citas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Cita</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_cita']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['hora']; ?></td>
                            <td><?php echo $row['cliente']; ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                            <td>
                                <form class="form-inline" action="actualizar_estado_cita.php" method="POST">
                                    <input type="hidden" name="id_cita" value="<?php echo $row['id_cita']; ?>">
                                    <select name="nuevo_estado" required>
                                        <option value="pendiente" <?php if ($row['estado'] === 'pendiente') echo 'selected'; ?>>Pendiente</option>
                                        <option value="confirmada" <?php if ($row['estado'] === 'confirmada') echo 'selected'; ?>>Confirmada</option>
                                        <option value="cancelada" <?php if ($row['estado'] === 'cancelada') echo 'selected'; ?>>Cancelada</option>
                                    </select>
                                    <button type="submit">Actualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay citas agendadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard_admin.php" class="btn">Volver al Panel</a>
    </div>
</body>
</html>
