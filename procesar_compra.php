<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener los productos del carrito del usuario
$sql_carrito = "SELECT c.id_producto, c.cantidad, p.precio 
                FROM carrito c 
                INNER JOIN productos p ON c.id_producto = p.id_producto 
                WHERE c.id_usuario = ?";
$stmt_carrito = $conexion->prepare($sql_carrito);
$stmt_carrito->bind_param("i", $id_usuario);
$stmt_carrito->execute();
$result_carrito = $stmt_carrito->get_result();

if ($result_carrito->num_rows > 0) {
    $compra_id = null;

    // Registrar cada producto en la tabla de compras
    $sql_compra = "INSERT INTO compras (id_usuario, id_producto, cantidad, precio, fecha_compra) 
                   VALUES (?, ?, ?, ?, NOW())";
    $stmt_compra = $conexion->prepare($sql_compra);

    while ($row = $result_carrito->fetch_assoc()) {
        $id_producto = $row['id_producto'];
        $cantidad = $row['cantidad'];
        $precio = $row['precio'];

        $stmt_compra->bind_param("iiid", $id_usuario, $id_producto, $cantidad, $precio);
        if ($stmt_compra->execute() && !$compra_id) {
            // Guardar el ID de la primera compra registrada
            $compra_id = $conexion->insert_id;
        }
    }

    // Vaciar el carrito después de registrar la compra
    $sql_vaciar_carrito = "DELETE FROM carrito WHERE id_usuario = ?";
    $stmt_vaciar_carrito = $conexion->prepare($sql_vaciar_carrito);
    $stmt_vaciar_carrito->bind_param("i", $id_usuario);
    $stmt_vaciar_carrito->execute();

    if ($compra_id) {
        // Redirigir al recibo con el ID correcto
        header("Location: recibo.php?compra_id=$compra_id");
        exit();
    } else {
        echo "Error: No se pudo registrar la compra.";
    }
} else {
    echo "El carrito está vacío. No se puede procesar la compra.";
}

$stmt_carrito->close();
$stmt_compra->close();
$conexion->close();
?>
<a href="productos.php">Volver a la tienda</a>
