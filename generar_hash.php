<?php
// Contraseña que quieres hashear
$password = 'admin123';
// Generar el hash de la contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash generado: " . $hash;
?>
