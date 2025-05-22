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
            // Inicializar contador de intentos si no existe
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 0;
            }

            $max_attempts = 3;

            // Comprobar si se excedió el límite de intentos
            if ($_SESSION['login_attempts'] >= $max_attempts) {
                $error = "Has excedido el número máximo de intentos. Por favor, inténtalo más tarde.";
                require __DIR__ . '/../views/auth/login.php';
                return; // Salir para no procesar más
            }

            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->adminModel->findByUser($usuario);

            if ($admin && password_verify($password, $admin['contraseña'])) {
                // Login correcto: resetear contador
                $_SESSION['login_attempts'] = 0;
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_usuario'] = $admin['usuario'];
                header("Location: index.php?controller=admin&action=dashboard");
                exit;
            } else {
                // Incrementar contador de intentos fallidos
                $_SESSION['login_attempts']++;
                $intentos_restantes = $max_attempts - $_SESSION['login_attempts'];
                $error = "Usuario o contraseña incorrectos. Te quedan $intentos_restantes intento(s).";
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
