<?php
require_once __DIR__ . '/../core/Database.php';

class Ingrediente {
    private $db;

    // Factores de conversión automáticos para unidades comunes
    private $factoresConversion = [
        'gramo' => 1,
        'kilogramo' => 1000,
        'quintal' => 46000,
        'mililitro' => 1,
        'litro' => 1000,
        'unidad' => 1
    ];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Ingrediente WHERE eliminado = 0 ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Ingrediente WHERE id = ? AND eliminado = 0");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear ingrediente con conversión automática del stock a unidad base
    public function create($nombre, $stock_ingresado, $unidad_medida, $unidad_compra) {
        $factor_conversion = $this->getFactorConversion($unidad_compra);
        $stock_base = $stock_ingresado * $factor_conversion;

        $stmt = $this->db->prepare("INSERT INTO Ingrediente (nombre, stock_actual, unidad_medida, unidad_compra, factor_conversion) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nombre, $stock_base, $unidad_medida, $unidad_compra, $factor_conversion]);
    }

    // Actualizar ingrediente con conversión automática del stock a unidad base
    public function update($id, $nombre, $stock_ingresado, $unidad_medida, $unidad_compra) {
        $factor_conversion = $this->getFactorConversion($unidad_compra);
        $stock_base = $stock_ingresado * $factor_conversion;

        $stmt = $this->db->prepare("UPDATE Ingrediente SET nombre = ?, stock_actual = ?, unidad_medida = ?, unidad_compra = ?, factor_conversion = ? WHERE id = ? AND eliminado = 0");
        return $stmt->execute([$nombre, $stock_base, $unidad_medida, $unidad_compra, $factor_conversion, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE Ingrediente SET eliminado = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtener factor de conversión automático o 1 si no existe
    public function getFactorConversion($unidad_compra) {
        $unidad_compra = strtolower($unidad_compra);
        return $this->factoresConversion[$unidad_compra] ?? 1;
    }
}
