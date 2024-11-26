<?php
session_start();
include('conexion.php');

// Verificar si el usuario está logueado y tiene una compra activa
if (!isset($_SESSION['id_usuario']) || !isset($_GET['compra_id'])) {
    die("Acceso denegado.");
}

$id_usuario = $_SESSION['id_usuario'];
$compra_id = $_GET['compra_id'];

// Obtener detalles de la compra
$sql = "SELECT c.fecha_compra, c.precio, p.nombre, p.precio AS precio_producto, c.cantidad 
        FROM compras c 
        INNER JOIN productos p ON c.id_producto = p.id_producto 
        WHERE c.id_usuario = ? AND c.id_compra = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_usuario, $compra_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No se encontraron detalles para esta compra.");
}

// Generar recibo
$compra = $result->fetch_all(MYSQLI_ASSOC);
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #ffffff;
        }
        .recibo {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        .recibo h1 {
            margin-bottom: 10px;
        }
        .recibo img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .recibo .folio {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .print-btn {
            margin-top: 20px;
            text-align: center;
        }
        .print-btn button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        .print-btn button:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="recibo">
        <img src="imagenes/barbertclgo.jpg" alt="Logo de la Barbería">
        <h1>Recibo de Compra</h1>
        <p class="folio">Folio de Compra: <?php echo str_pad($compra_id, 6, "0", STR_PAD_LEFT); ?></p>
        <p><strong>Fecha de Compra:</strong> <?php echo $compra[0]['fecha_compra']; ?></p>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compra as $item): 
                    $subtotal = $item['cantidad'] * $item['precio_producto'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $item['nombre']; ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>$<?php echo number_format($item['precio_producto'], 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td class="total">$<?php echo number_format($total, 2); ?></td>
                </tr>
            </tbody>
        </table>
        <div class="print-btn">
            <button onclick="window.print()">Imprimir Recibo</button>
        </div>
        <div class="footer">
            <p>Gracias por visitar <a href="index.php">Barber TC</a>. ¡Esperamos verte pronto!</p>
        </div>
    </div>
</body>
</html>
