<?php
include('conexion.php');

// Verificar si se envió un ID
if (!isset($_GET['id'])) {
    echo "Error: No se proporcionó un ID.";
    exit();
}

$id_usuario = $_GET['id'];

// Obtener los datos del usuario
$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Error: Usuario no encontrado.";
    exit();
}

$usuario = $result->fetch_assoc();

// Procesar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $sql_update = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id_usuario = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nombre, $email, $rol, $id_usuario);

    if ($stmt_update->execute()) {
        echo "Usuario actualizado correctamente.";
        header("Location: ver_usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            text-align: center;
        }
        .form-container {
            margin-top: 50px;
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
        .form-container input, select {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 80%;
            border: none;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #ff4500;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #e03e00;
        }
        .back-link {
            color: white;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
        .back-link:hover {
            color: #ff4500;
        }
    </style>
</head>
<body>
    <h1>Editar Usuario</h1>
    <div class="form-container">
        <form action="" method="POST">
            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            <select name="rol" required>
                <option value="cliente" <?php echo $usuario['rol'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                <option value="empleado" <?php echo $usuario['rol'] === 'empleado' ? 'selected' : ''; ?>>Empleado</option>
                <option value="admin" <?php echo $usuario['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
            </select>
            <button type="submit">Actualizar</button>
        </form>
        <a href="ver_usuarios.php" class="back-link">Volver a la lista de usuarios</a>
    </div>
</body>
</html>
