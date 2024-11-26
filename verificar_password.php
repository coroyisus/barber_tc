<?php
$password_ingresada = 'admin123';
$hash_almacenado = '$2y$10$WzCr21s8l5i./tB08aZbHO2zml4R.U5OZ2U/0YO4y8nqvS7qSiOgi';

if (password_verify($password_ingresada, $hash_almacenado)) {
    echo "La contraseña es válida.";
} else {
    echo "La contraseña no coincide.";
}
?>
