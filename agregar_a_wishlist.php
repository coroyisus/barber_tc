<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para agregar productos a tu Wishlist.'); window.location.href='login.html';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_producto = $_POST['id_producto'];

// Verificar si el producto ya está en la Wishlist
$sql_check = "SELECT * FROM wishlist WHERE id_usuario = ? AND id_producto = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("ii", $id_usuario, $id_producto);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Este producto ya está en tu Wishlist.'); window.history.back();</script>";
    exit();
}

// Insertar en la Wishlist
$sql_insert = "INSERT INTO wishlist (id_usuario, id_producto) VALUES (?, ?)";
$stmt_insert = $conexion->prepare($sql_insert);
$stmt_insert->bind_param("ii", $id_usuario, $id_producto);

if ($stmt_insert->execute()) {
    echo "<script>alert('Producto agregado a tu Wishlist.'); window.history.back();</script>";
} else {
    echo "<script>alert('Error al agregar el producto a la Wishlist.'); window.history.back();</script>";
}

$stmt_check->close();
$stmt_insert->close();
$conexion->close();
?>
