<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Eliminar registros relacionados en la tabla "carrito"
    $sql_eliminar_carrito = "DELETE FROM carrito WHERE id_producto = ?";
    $stmt_carrito = $conexion->prepare($sql_eliminar_carrito);
    $stmt_carrito->bind_param("i", $id_producto);
    $stmt_carrito->execute();

    // Eliminar el producto de la tabla "productos"
    $sql_eliminar_producto = "DELETE FROM productos WHERE id_producto = ?";
    $stmt_producto = $conexion->prepare($sql_eliminar_producto);
    $stmt_producto->bind_param("i", $id_producto);
    if ($stmt_producto->execute()) {
        echo "<script>alert('Producto eliminado correctamente.'); window.location.href='admin_productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto.'); window.location.href='admin_productos.php';</script>";
    }
} else {
    echo "<script>alert('ID de producto no especificado.'); window.location.href='admin_productos.php';</script>";
}
?>
