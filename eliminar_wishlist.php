<?php
include 'conexion.php';

// Verificar si se envió el formulario con el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_wishlist'])) {
    $id_wishlist = intval($_POST['id_wishlist']); // Sanitizar el ID recibido

    // Consulta para eliminar el producto de la lista de deseos
    $sql = "DELETE FROM wishlist WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_wishlist);

    if ($stmt->execute()) {
        // Redirigir de nuevo a la lista de deseos después de eliminar
        header('Location: wishlist.php');
        exit();
    } else {
        echo "Error al eliminar el producto de la lista de deseos.";
    }
} else {
    echo "Acceso no válido.";
}
?>
