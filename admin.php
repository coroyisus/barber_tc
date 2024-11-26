<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barber_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        a, button {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        a:hover, button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Administrar Productos</h1>
    <a href="formulario_producto.html">
        <button>Agregar Producto</button>
    </a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id_producto']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>\${$row['precio']}</td>
                        <td>{$row['stock']}</td>
                        <td><img src='{$row['imagen']}' alt='Imagen' style='width:50px; height:50px;'></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay productos disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
