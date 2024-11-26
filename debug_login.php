<?php
include('conexion.php');

$email = 'admin@example.com'; // Cambia esto si es necesario
$password = 'admin123'; // Contraseña que estás probando

// Consulta para obtener el usuario
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Hash almacenado: " . $row['password'] . "<br>";

    // Verificar la contraseña
    if (password_verify($password, $row['password'])) {
        echo "La contraseña coincide.<br>";
    } else {
        echo "La contraseña no coincide.<br>";
    }
} else {
    echo "Usuario no encontrado.<br>";
}
?>
