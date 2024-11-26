<?php
include('conexion.php'); // Incluye la conexión a la base de datos

// Procesar la eliminación de productos
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Procesar la adición de productos
if (isset($_POST['add_product'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdi", $nombre, $precio, $stock);
    $stmt->execute();
}

// Consultar productos
$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2e2e2e;
            color: #fff;
            padding: 20px;
        }
        h1, h2 {
            color: #ff4500;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            background-color: #333;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        form label {
            display: block;
            margin-bottom: 5px;
            color: #ff4500;
        }
        form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
        }
        form button {
            background-color: #ff4500;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #ff3000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background-color: #ff4500;
            color: #fff;
            padding: 10px;
        }
        td {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .boton {
            background-color: #ff4500;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }
        .boton:hover {
            background-color: #ff3000;
        }
    </style>
</head>
<body>
    <h1>Administrar Productos</h1>

    <h2>Agregar Producto</h2>
    <form action="admin_productos.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <button type="submit" name="add_product">Agregar Producto</button>
    </form>

    <h2>Productos Actuales</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td>$<?php echo number_format($row['precio'], 2); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <form action="admin_productos.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id_producto']; ?>">
                            <button type="submit" class="boton">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conexion->close(); ?>
