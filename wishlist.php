<?php
include 'conexion.php';

// Verifica si el usuario está autenticado
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['id_usuario']; // ID del usuario actual

// Consulta para obtener los productos en la lista de deseos
$sql = "SELECT wishlist.id, productos.nombre AS producto, productos.precio, productos.imagen
        FROM wishlist
        INNER JOIN productos ON wishlist.id_producto = productos.id_producto
        WHERE wishlist.id_usuario = $id_usuario";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Lista de Deseos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace a un archivo CSS -->
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
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ff4500;
        }
        tr:nth-child(even) {
            background-color: #333333;
        }
        tr:nth-child(odd) {
            background-color: #2a2a2a;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .btn {
            background-color: #ff4500;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #e03e00;
        }
        .no-products {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
            color: #ff4500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mi Lista de Deseos</h1>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['producto']; ?></td>
                            <td><?php echo number_format($row['precio'], 2); ?> MXN</td>
                            <td>
                                <img src="imagenes/<?php echo $row['imagen']; ?>" alt="<?php echo $row['producto']; ?>">
                            </td>
                            <td>
                                <form action="eliminar_wishlist.php" method="POST">
                                    <input type="hidden" name="id_wishlist" value="<?php echo $row['id']; ?>">
                                    <button class="btn" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-products">No tienes productos en tu lista de deseos.</p>
        <?php endif; ?>
    </div>
</body>
</html>
