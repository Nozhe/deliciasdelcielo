<?php
require_once __DIR__ . '/../models/Receta.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Ingrediente.php';
require_once __DIR__ . '/AuthController.php';

class RecetaController {
    private $recetaModel;
    private $productoModel;
    private $ingredienteModel;

    public function __construct() {
        AuthController::checkAuth();
        $this->recetaModel = new Receta();
        $this->productoModel = new Producto();
        $this->ingredienteModel = new Ingrediente();
    }

    public function index() {
        $producto_id = $_GET['producto_id'] ?? null;
        if (!$producto_id) {
            header("Location: index.php?controller=producto&action=index");
            exit;
        }

        $producto = $this->productoModel->getById($producto_id);
        if (!$producto) {
            header("Location: index.php?controller=producto&action=index");
            exit;
        }

        $recetas = $this->recetaModel->getByProductoId($producto_id);
        $ingredientes = $this->ingredienteModel->getAll();

        require __DIR__ . '/../views/recetas/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = $_POST['producto_id'];
            $ingrediente_id = $_POST['ingrediente_id'];
            $cantidad_necesaria = floatval($_POST['cantidad_necesaria']);

            $this->recetaModel->create($producto_id, $ingrediente_id, $cantidad_necesaria);
            header("Location: index.php?controller=receta&action=index&producto_id=" . $producto_id);
            exit;
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cantidad_necesaria = floatval($_POST['cantidad_necesaria']);
            $producto_id = $_POST['producto_id'];

            $this->recetaModel->update($id, $cantidad_necesaria);
            header("Location: index.php?controller=receta&action=index&producto_id=" . $producto_id);
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        $producto_id = $_GET['producto_id'] ?? null;
        if ($id && $producto_id) {
            $this->recetaModel->delete($id);
        }
        header("Location: index.php?controller=receta&action=index&producto_id=" . $producto_id);
        exit;
    }
}
