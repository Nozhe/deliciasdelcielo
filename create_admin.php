<?php
require_once __DIR__ . '/app/models/Admin.php';

$admin = new Admin();

$usuario = 'admin';
$password = 'root';

if ($admin->findByUser($usuario)) {
    echo "El usuario admin ya existe.";
    exit;
}

if ($admin->create($usuario, $password)) {
    echo "Administrador creado con usuario: $usuario y contraseña: $password";
} else {
    echo "Error al crear administrador.";
}
