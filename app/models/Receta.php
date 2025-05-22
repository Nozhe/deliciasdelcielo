<?php
require_once __DIR__ . '/../core/Database.php';

class Receta {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByProductoId($producto_id) {
        $stmt = $this->db->prepare("
            SELECT r.id, r.producto_id, r.ingrediente_id, r.cantidad_necesaria, i.nombre AS ingrediente_nombre, i.unidad_medida
            FROM Receta r
            JOIN Ingrediente i ON r.ingrediente_id = i.id
            WHERE r.producto_id = ?
        ");
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($producto_id, $ingrediente_id, $cantidad_necesaria) {
        $stmt = $this->db->prepare("INSERT INTO Receta (producto_id, ingrediente_id, cantidad_necesaria) VALUES (?, ?, ?)");
        return $stmt->execute([$producto_id, $ingrediente_id, $cantidad_necesaria]);
    }

    public function update($id, $cantidad_necesaria) {
        $stmt = $this->db->prepare("UPDATE Receta SET cantidad_necesaria = ? WHERE id = ?");
        return $stmt->execute([$cantidad_necesaria, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Receta WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
