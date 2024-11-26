<?php
include 'conexion.php'; // Conexión a la base de datos

$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2e2e2e;
            color: #fff;
            padding: 20px;
        }
        .producto {
            background-color: #333;
            border-radius: 10px;
            margin: 20px 0;
            padding: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .producto img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin-right: 20px;
        }
        .producto h3 {
            margin: 0;
        }
        .producto p {
            margin: 5px 0;
        }
        .botones {
            margin-top: 10px;
        }
        .botones button {
            background-color: #ff4500;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }
        .botones button:hover {
            background-color: #ff3000;
        }
    </style>
</head>
<body>
    <h1>Lista de Productos</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Asignar descripciones personalizadas según el nombre del producto
            switch (strtolower($row['nombre'])) {
                case 'cera para cabello':
                    $descripcion = 'Ideal para peinados con estilo, aporta un acabado mate y duradero.';
                    break;
                case 'shampoo anti caída':
                    $descripcion = 'Fortalece las raíces y reduce la caída del cabello. Uso diario.';
                    break;
                case 'peine profesional':
                    $descripcion = 'Diseñado para estilistas, perfecto para cortes precisos y peinados.';
                    break;
                case 'cera mate':
                    $descripcion = 'Aporta textura y volumen con un acabado mate natural.';
                    break;
                default:
                    $descripcion = 'Un excelente producto para tu cuidado personal.';
            }

            echo "<div class='producto'>";
            echo "<img src='{$row['imagen']}' alt='{$row['nombre']}'>";
            echo "<div>";
            echo "<h3>{$row['nombre']}</h3>";
            echo "<p><strong>Precio:</strong> {$row['precio']} MXN</p>";
            echo "<p><strong>Descripción:</strong> {$descripcion}</p>";
            echo "<div class='botones'>";
            // Botón para agregar al carrito
            echo "<form action='agregar_carrito.php' method='POST' style='display:inline;'>";
            echo "<input type='hidden' name='id_producto' value='{$row['id_producto']}'>";
            echo "<input type='hidden' name='cantidad' value='1'>"; // Campo oculto para cantidad
            echo "<button type='submit'>Agregar al Carrito</button>";
            echo "</form>";
            // Botón para agregar a la lista de deseos (wishlist)
            echo "<form action='agregar_a_wishlist.php' method='POST' style='display:inline;'>";
            echo "<input type='hidden' name='id_producto' value='{$row['id_producto']}'>";
            echo "<button type='submit'>Agregar a Wishlist</button>";
            echo "</form>";
            echo "</div>"; // Fin botones
            echo "</div>"; // Fin descripción
            echo "</div>"; // Fin producto
        }
    } else {
        echo "<p>No hay productos disponibles.</p>";
    }

    $conexion->close();
    ?>
</body>
</html>
