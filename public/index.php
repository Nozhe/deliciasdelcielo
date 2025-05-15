<?php

// Carga automática simple
spl_autoload_register(function ($class) {
    $paths = ['../app/controllers/', '../app/models/', '../app/core/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Obtener controlador y acción
$controllerName = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

$controllerClass = ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
    $controller = new $controllerClass();
    $controller->$action();
} else {
    echo "Página no encontrada.";
}
