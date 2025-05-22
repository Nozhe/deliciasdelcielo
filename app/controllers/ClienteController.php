<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/AuthController.php';

class ClienteController {
    private $clienteModel;

    public function __construct() {
        AuthController::checkAuth();
        $this->clienteModel = new Cliente();
    }

    public function index() {
        $clientes = $this->clienteModel->getAll();
        require __DIR__ . '/../views/clientes/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $razon_social = trim($_POST['razon_social']);
            $carnet_identidad_o_nit = trim($_POST['carnet_identidad_o_nit']) ?: null;

            $this->clienteModel->create($razon_social, $carnet_identidad_o_nit);
            header("Location: index.php?controller=cliente&action=index");
            exit;
        }
        require __DIR__ . '/../views/clientes/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=cliente&action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $razon_social = trim($_POST['razon_social']);
            $carnet_identidad_o_nit = trim($_POST['carnet_identidad_o_nit']) ?: null;

            $this->clienteModel->update($id, $razon_social, $carnet_identidad_o_nit);
            header("Location: index.php?controller=cliente&action=index");
            exit;
        }

        $cliente = $this->clienteModel->getById($id);
        if (!$cliente) {
            header("Location: index.php?controller=cliente&action=index");
            exit;
        }

        require __DIR__ . '/../views/clientes/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->clienteModel->delete($id);
        }
        header("Location: index.php?controller=cliente&action=index");
        exit;
    }
}
