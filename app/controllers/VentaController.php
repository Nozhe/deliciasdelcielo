<?php
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/AuthController.php';

class VentaController {
    private $ventaModel;
    private $clienteModel;
    private $productoModel;

    public function __construct() {
        AuthController::checkAuth();
        $this->ventaModel = new Venta();
        $this->clienteModel = new Cliente();
        $this->productoModel = new Producto();
    }

    public function index() {
        $ventas = $this->ventaModel->getAll();
        require __DIR__ . '/../views/ventas/index.php';
    }

    // app/controllers/VentaController.php

    public function create() {
        $clientes = $this->clienteModel->getAll();
        $productos = $this->productoModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_id = $_POST['cliente_id'] ?: null;
            $tipo_venta = $_POST['tipo_venta'];
            $fecha_entrega = $_POST['fecha_entrega'] ?: null;

            $productos_post = $_POST['productos'] ?? [];
            $cantidades_post = $_POST['cantidades'] ?? [];

            $productos = [];
            for ($i = 0; $i < count($productos_post); $i++) {
                $prod_id = intval($productos_post[$i]);
                $cant = intval($cantidades_post[$i]);
                if ($prod_id > 0 && $cant > 0) {
                    $productos[] = ['producto_id' => $prod_id, 'cantidad' => $cant];
                }
            }

            if (empty($productos)) {
                $error = "Debe agregar al menos un producto con cantidad válida.";
                require __DIR__ . '/../views/ventas/create.php';
                return;
            }

            $success = $this->ventaModel->create($cliente_id, $tipo_venta, $fecha_entrega, $productos);

            if ($success) {
                header("Location: index.php?controller=venta&action=index");
                exit;
            } else {
                $error = "Error al registrar la venta. Puede que no haya suficiente stock de algún ingrediente.";
                require __DIR__ . '/../views/ventas/create.php';
            }
        } else {
            require __DIR__ . '/../views/ventas/create.php';
        }
    }


    public function view() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=venta&action=index");
            exit;
        }

        $venta = $this->ventaModel->getById($id);
        if (!$venta) {
            header("Location: index.php?controller=venta&action=index");
            exit;
        }

        require __DIR__ . '/../views/ventas/view.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->ventaModel->delete($id);
        }
        header("Location: index.php?controller=venta&action=index");
        exit;
    }
}
