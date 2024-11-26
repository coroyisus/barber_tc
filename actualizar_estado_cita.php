<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cita = $_POST['id_cita'];
    $nuevo_estado = $_POST['nuevo_estado'];

    // Validar que el nuevo estado sea válido
    $estados_validos = ['pendiente', 'confirmada', 'cancelada'];
    if (!in_array($nuevo_estado, $estados_validos)) {
        header('Location: ver_citas.php');
        exit();
    }

    // Actualizar el estado en la base de datos
    $sql = "UPDATE citas SET estado = ? WHERE id_cita = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('si', $nuevo_estado, $id_cita);

    if ($stmt->execute()) {
        header('Location: ver_citas.php?mensaje=estado_actualizado');
    } else {
        header('Location: ver_citas.php?mensaje=error_actualizar');
    }

    $stmt->close();
    $conexion->close();
} else {
    header('Location: ver_citas.php');
}
