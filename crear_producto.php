<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barber_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $descripcion = $_POST["descripcion"] ?? '';
    $precio = $_POST["precio"] ?? 0;
    $stock = $_POST["stock"] ?? 0;
    $imagen = $_FILES["imagen"] ?? null;

    // Validar si se subió la imagen
    if ($imagen && $imagen["tmp_name"]) {
        // Crear la carpeta 'uploads' si no existe
        $carpetaUploads = "uploads/";
        if (!file_exists($carpetaUploads)) {
            mkdir($carpetaUploads, 0777, true);
        }

        // Ruta completa donde se guardará la imagen
        $ruta_imagen = $carpetaUploads . basename($imagen["name"]);

        // Mover la imagen subida
        if (move_uploaded_file($imagen["tmp_name"], $ruta_imagen)) {
            // Insertar datos en la base de datos
            $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $nombre, $descripcion, $precio, $stock, $ruta_imagen);

            if ($stmt->execute()) {
                echo "Producto agregado correctamente.";
                header("Location: ver_productos.php");
                exit;
            } else {
                echo "Error al guardar el producto: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al mover la imagen al directorio 'uploads'.";
        }
    } else {
        echo "No se subió ninguna imagen o hubo un problema con el archivo.";
    }
} else {
    echo "Método no permitido.";
}

$conn->close();
?>
