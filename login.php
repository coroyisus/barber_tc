<?php
include('conexion.php'); // Archivo para la conexión a la base de datos
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // Obtener el correo del formulario
    $password = trim($_POST['password']); // Obtener la contraseña del formulario

    // Consulta para verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];

            // Redirigir según el rol del usuario
            if ($_SESSION['rol'] === 'admin') {
                header("Location: dashboard_admin.php"); // Cambia a la página del administrador
            } else {
                header("Location: menu.php"); // Cambia a la página del cliente/empleado
            }
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='login.html';</script>";
        }
    } else {
        // Usuario no encontrado
        echo "<script>alert('Usuario no encontrado.'); window.location.href='login.html';</script>";
    }
} else {
    // Redirigir si el método no es POST
    echo "<script>alert('Método no permitido. Usa el formulario para iniciar sesión.'); window.location.href='login.html';</script>";
}
?>
