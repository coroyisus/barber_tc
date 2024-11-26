<?php
include('conexion.php');
session_start();

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'cliente') {
    die("<script>alert('Acceso denegado. Debes iniciar sesión como cliente.'); window.location.href='login.html';</script>");
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener los datos del usuario
$sql = "SELECT nombre, email FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
} else {
    die("Error en la consulta de usuario: " . $stmt->error);
}

// Obtener citas
$sqlCitas = "SELECT fecha, hora, servicio, estado FROM citas WHERE id_usuario = ? ORDER BY fecha DESC";
$stmtCitas = $conexion->prepare($sqlCitas);
$stmtCitas->bind_param("i", $id_usuario);
$stmtCitas->execute();
$citas = $stmtCitas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #111;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
        }
        .menu {
            padding: 15px;
            text-align: center;
            background-color: #222;
        }
        .menu a {
            margin: 0 10px;
            color: #ff4500;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #ff4500;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #ff4500;
            color: white;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background-color: #333;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
        }
        .btn {
            background-color: #ff4500;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #ff6347;
        }
    </style>
</head>
<body>
    <header>
        Mi Perfil
    </header>
    <div class="menu">
        <a href="historial_compras.php">Historial de Compras</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>

        <h3>Mis Citas</h3>
        <?php if ($citas->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $citas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['hora']; ?></td>
                            <td><?php echo htmlspecialchars($row['servicio']); ?></td>
                            <td><?php echo htmlspecialchars($row['estado']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes citas programadas.</p>
        <?php endif; ?>
    </div>
</body>
</html>
