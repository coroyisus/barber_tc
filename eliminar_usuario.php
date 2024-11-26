<?php
include('conexion.php');

// Verificar si se envió un ID
if (!isset($_GET['id'])) {
    echo "Error: No se proporcionó un ID.";
    exit();
}

$id_usuario = $_GET['id'];

// Eliminar el usuario de la base de datos
$sql = "DELETE FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);

if ($stmt->execute()) {
    echo "Usuario eliminado correctamente.";
    header("Location: ver_usuarios.php");
    exit();
} else {
    echo "Error al eliminar el usuario.";
}
?>
