<?php
require_once __DIR__ . '/../models/Ingrediente.php';
require_once __DIR__ . '/AuthController.php';

class IngredienteController {
    private $ingredienteModel;

    public function __construct() {
        AuthController::checkAuth();
        $this->ingredienteModel = new Ingrediente();
    }

    public function index() {
        $ingredientes = $this->ingredienteModel->getAll();
        require __DIR__ . '/../views/ingredientes/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $stock_ingresado = floatval($_POST['stock_actual']);
            $unidad_medida = trim($_POST['unidad_medida']);
            $unidad_compra = trim($_POST['unidad_compra']);

            $this->ingredienteModel->create($nombre, $stock_ingresado, $unidad_medida, $unidad_compra);
            header("Location: index.php?controller=ingrediente&action=index");
            exit;
        }
        require __DIR__ . '/../views/ingredientes/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=ingrediente&action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $stock_ingresado = floatval($_POST['stock_actual']);
            $unidad_medida = trim($_POST['unidad_medida']);
            $unidad_compra = trim($_POST['unidad_compra']);

            $this->ingredienteModel->update($id, $nombre, $stock_ingresado, $unidad_medida, $unidad_compra);
            header("Location: index.php?controller=ingrediente&action=index");
            exit;
        }

        $ingrediente = $this->ingredienteModel->getById($id);
        if (!$ingrediente) {
            header("Location: index.php?controller=ingrediente&action=index");
            exit;
        }

        // Convertir stock_actual (unidad base) a unidad de compra para mostrar en el formulario
        $stock_en_unidad_compra = $ingrediente['stock_actual'] / $ingrediente['factor_conversion'];
        $ingrediente['stock_mostrar'] = round($stock_en_unidad_compra, 4);

        require __DIR__ . '/../views/ingredientes/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->ingredienteModel->delete($id);
        }
        header("Location: index.php?controller=ingrediente&action=index");
        exit;
    }
}
