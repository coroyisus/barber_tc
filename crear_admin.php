<?php
include('conexion.php');

// Información del nuevo administrador
$nombre = 'Administrador';
$email = 'admin@example.com';
$password = 'admin123'; // Contraseña para el administrador
$rol = 'admin'; // Rol del usuario

// Generar el hash de la contraseña
$hash_password = password_hash($password, PASSWORD_DEFAULT);

// Verificar si ya existe un usuario con este email
$sql_check = "SELECT * FROM usuarios WHERE email = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Ya existe un usuario con este correo.";
} else {
    // Insertar el nuevo administrador en la base de datos
    $sql_insert = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $nombre, $email, $hash_password, $rol);

    if ($stmt_insert->execute()) {
        echo "Nuevo administrador creado exitosamente.<br>";
        echo "Email: $email<br>";
        echo "Contraseña: $password<br>";
    } else {
        echo "Error al crear el administrador.";
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conexion->close();
?>
