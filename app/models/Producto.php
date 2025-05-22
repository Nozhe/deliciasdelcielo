<?php
require_once __DIR__ . '/../core/Database.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Producto WHERE eliminado = 0 ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Producto WHERE id = ? AND eliminado = 0");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $tipo, $precio, $cantidad_fija_domingo = null, $cantidad_por_receta = 1) {
        $stmt = $this->db->prepare("INSERT INTO Producto (nombre, tipo, precio, cantidad_fija_domingo, cantidad_por_receta) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nombre, $tipo, $precio, $cantidad_fija_domingo, $cantidad_por_receta]);
    }

    public function update($id, $nombre, $tipo, $precio, $cantidad_fija_domingo = null, $cantidad_por_receta = 1) {
        $stmt = $this->db->prepare("UPDATE Producto SET nombre = ?, tipo = ?, precio = ?, cantidad_fija_domingo = ?, cantidad_por_receta = ? WHERE id = ? AND eliminado = 0");
        return $stmt->execute([$nombre, $tipo, $precio, $cantidad_fija_domingo, $cantidad_por_receta, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE Producto SET eliminado = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
