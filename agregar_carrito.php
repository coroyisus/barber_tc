<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_producto = $_POST['id_producto']; // ID del producto enviado desde un formulario
$cantidad = $_POST['cantidad']; // Cantidad del producto

// Agregar producto al carrito
$sql = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iii", $id_usuario, $id_producto, $cantidad);

if ($stmt->execute()) {
    header("Location: carrito.php");
} else {
    echo "Error al agregar al carrito.";
}

$stmt->close();
?>
