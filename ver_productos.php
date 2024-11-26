<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Disponibles</title>
    <style>
        /* Estilo general */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            text-align: center;
            border: 1px solid #ddd;
            font-size: 18px; /* Tamaño de texto más grande */
            padding: 10px;
        }

        table thead tr {
            background-color: #007bff;
            color: #fff;
            font-size: 20px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f1f1f1;
        }

        table img {
            max-width: 100%; /* Imagen ajustable */
            height: auto; /* Mantener proporción */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-message {
            text-align: center;
            font-size: 18px;
            color: #999;
        }

        .price {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "barber_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("<p>Error de conexión: " . $conn->connect_error . "</p>");
    }

    // Consultar los productos
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);

    echo "<h1>Productos Disponibles</h1>";

    if ($result->num_rows > 0) {
        echo "<table>
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
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id_producto"] . "</td>
                    <td>" . $row["nombre"] . "</td>
                    <td>" . $row["descripcion"] . "</td>
                    <td class='price'>$ " . number_format($row["precio"], 2) . "</td>
                    <td>" . $row["stock"] . "</td>
                    <td><img src='uploads/" . $row["imagen"] . "' alt='" . $row["nombre"] . "'></td>
                  </tr>";
        }

        echo "</tbody>
            </table>";
    } else {
        echo "<p class='empty-message'>No hay productos disponibles</p>";
    }

    $conn->close();
    ?>
</body>
</html>
