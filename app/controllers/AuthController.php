<?php
require_once __DIR__ . '/../models/Admin.php';

class AuthController {
    private $adminModel;

    public function __construct() {
        session_start();
        $this->adminModel = new Admin();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->adminModel->findByUser($usuario);

            if ($admin && password_verify($password, $admin['contraseña'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_usuario'] = $admin['usuario'];
                header("Location: index.php?controller=admin&action=dashboard");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos";
                require __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }

    public static function checkAuth() {
        session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }
}
