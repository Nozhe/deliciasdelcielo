<?php
require_once __DIR__ . '/AuthController.php';

class AdminController {
    public function dashboard() {
        AuthController::checkAuth();
        $usuario = $_SESSION['admin_usuario'];
        require __DIR__ . '/../views/admin/dashboard.php';
    }
}
