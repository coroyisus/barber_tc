<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

if (isset($_GET['id'])) {
    $id_carrito = intval($_GET['id']);
    $stmt = $conexion->prepare("DELETE FROM carrito WHERE id_carrito = ?");
    $stmt->bind_param("i", $id_carrito);

    if ($stmt->execute()) {
        header("Location: carrito.php");
    } else {
        echo "Error al eliminar el producto del carrito.";
    }
    $stmt->close();
} else {
    echo "ID no especificado.";
}
?>
