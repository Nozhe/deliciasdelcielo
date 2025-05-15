<?php
if(session_status() == PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Delicias del Cielo</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
<div class="container">
    <nav class="sidebar">
        <div class="sidebar-logo">
            <img src="img/logo.png" alt="Logo Delicias del Cielo" />
        </div>
        <h2>Delicias del Cielo</h2>
        <ul>
            <li><a href="index.php?controller=admin&action=dashboard" class="<?php echo ($_GET['controller'] ?? '') == 'admin' ? 'active' : ''; ?>">Inicio</a></li>
            <li><a href="index.php?controller=ingrediente&action=index" class="<?php echo ($_GET['controller'] ?? '') == 'ingrediente' ? 'active' : ''; ?>">Inventario Ingredientes</a></li>
            <li><a href="index.php?controller=cliente&action=index" class="<?php echo ($_GET['controller'] ?? '') == 'cliente' ? 'active' : ''; ?>">Clientes Recurrentes</a></li>
            <li><a href="index.php?controller=producto&action=index" class="<?php echo ($_GET['controller'] ?? '') == 'producto' ? 'active' : ''; ?>">Productos</a></li>
            <li><a href="index.php?controller=venta&action=index" class="<?php echo ($_GET['controller'] ?? '') == 'venta' ? 'active' : ''; ?>">Ventas</a></li>
            <li><a href="index.php?controller=auth&action=logout">Cerrar sesión (<?php echo htmlspecialchars($_SESSION['admin_usuario']); ?>)</a></li>
        </ul>
    </nav>

    <main class="content">
