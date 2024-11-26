<?php
include('conexion.php');

// Información del administrador existente
$email = 'admin@example.com'; // Correo del administrador a actualizar
$nuevo_nombre = 'Administrador Actualizado'; // Nuevo nombre (opcional)
$nueva_password = 'admin1234'; // Nueva contraseña
$rol = 'admin'; // Asegúrate de que el rol sea correcto

// Generar el hash de la nueva contraseña
$hash_password = password_hash($nueva_password, PASSWORD_DEFAULT);

// Actualizar los datos del administrador
$sql_update = "UPDATE usuarios SET nombre = ?, password = ?, rol = ? WHERE email = ?";
$stmt_update = $conexion->prepare($sql_update);
$stmt_update->bind_param("ssss", $nuevo_nombre, $hash_password, $rol, $email);

if ($stmt_update->execute()) {
    echo "Administrador actualizado correctamente.<br>";
    echo "Email: $email<br>";
    echo "Nueva Contraseña: $nueva_password<br>";
} else {
    echo "Error al actualizar el administrador.";
}

$stmt_update->close();
$conexion->close();
?>
