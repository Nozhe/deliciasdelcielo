<?php
require_once __DIR__ . '/../core/Database.php';

class Cliente {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Cliente WHERE eliminado = 0 ORDER BY razon_social");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Cliente WHERE id = ? AND eliminado = 0");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($razon_social, $carnet_identidad_o_nit) {
        $stmt = $this->db->prepare("INSERT INTO Cliente (razon_social, carnet_identidad_o_nit) VALUES (?, ?)");
        return $stmt->execute([$razon_social, $carnet_identidad_o_nit ?: null]);
    }

    public function update($id, $razon_social, $carnet_identidad_o_nit) {
        $stmt = $this->db->prepare("UPDATE Cliente SET razon_social = ?, carnet_identidad_o_nit = ? WHERE id = ? AND eliminado = 0");
        return $stmt->execute([$razon_social, $carnet_identidad_o_nit ?: null, $id]);
    }

    public function delete($id) {
        // Borrado lógico
        $stmt = $this->db->prepare("UPDATE Cliente SET eliminado = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
