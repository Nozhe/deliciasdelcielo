<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/AuthController.php';

class ProductoController {
    private $productoModel;

    public function __construct() {
        AuthController::checkAuth();
        $this->productoModel = new Producto();
    }

    public function index() {
        $productos = $this->productoModel->getAll();
        require __DIR__ . '/../views/productos/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $tipo = $_POST['tipo'];
            $precio = floatval($_POST['precio']);
            $cantidad_fija_domingo = $_POST['cantidad_fija_domingo'] !== '' ? intval($_POST['cantidad_fija_domingo']) : null;
            $cantidad_por_receta = intval($_POST['cantidad_por_receta']) ?: 1;

            $this->productoModel->create($nombre, $tipo, $precio, $cantidad_fija_domingo, $cantidad_por_receta);
            header("Location: index.php?controller=producto&action=index");
            exit;
        }
        require __DIR__ . '/../views/productos/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=producto&action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $tipo = $_POST['tipo'];
            $precio = floatval($_POST['precio']);
            $cantidad_fija_domingo = $_POST['cantidad_fija_domingo'] !== '' ? intval($_POST['cantidad_fija_domingo']) : null;
            $cantidad_por_receta = intval($_POST['cantidad_por_receta']) ?: 1;

            $this->productoModel->update($id, $nombre, $tipo, $precio, $cantidad_fija_domingo, $cantidad_por_receta);
            header("Location: index.php?controller=producto&action=index");
            exit;
        }

        $producto = $this->productoModel->getById($id);
        if (!$producto) {
            header("Location: index.php?controller=producto&action=index");
            exit;
        }

        require __DIR__ . '/../views/productos/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->productoModel->delete($id);
        }
        header("Location: index.php?controller=producto&action=index");
        exit;
    }
}
