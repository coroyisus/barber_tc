<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Variables del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagenNombre = $_FILES['imagen']['name'];
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        $imagenDestino = "imagenes/" . $imagenNombre;

        // Mover la imagen a la carpeta 'imagenes'
        if (move_uploaded_file($imagenTmp, $imagenDestino)) {
            // Insertar el producto en la base de datos
            $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) 
                    VALUES ('$nombre', '$descripcion', '$precio', '$imagenDestino')";

            if ($conexion->query($sql) === TRUE) {
                echo "<p style='color: green;'>Producto agregado correctamente.</p>";
            } else {
                echo "<p style='color: red;'>Error: " . $conexion->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error al subir la imagen.</p>";
        }
    } else {
        echo "<p style='color: red;'>No se seleccionó ninguna imagen o hubo un error.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2e2e2e;
            color: #fff;
            padding: 20px;
        }
        form {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Agregar Producto</h1>
    <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

        <label for="precio">Precio (MXN):</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
