<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $sql = "UPDATE productos SET nombre = ?, precio = ? WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdi", $nombre, $precio, $id_producto);

    if ($stmt->execute()) {
        header("Location: gestion_productos.php");
        exit();
    } else {
        echo "Error al actualizar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #333;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            text-align: center;
        }
        h1 {
            color: #ff4500;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #ff4500;
            outline: none;
        }
        button {
            background-color: #ff4500;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #e03e00;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            color: #ff4500;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form method="POST">
            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>
            <button type="submit">Guardar Cambios</button>
        </form>
        <a href="gestion_productos.php">Volver a Gestión de Productos</a>
    </div>
</body>
</html>
