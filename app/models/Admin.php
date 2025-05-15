<?php
require_once __DIR__ . '/../core/Database.php';

class Admin {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($usuario, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Administrador (usuario, contraseña) VALUES (?, ?)");
        return $stmt->execute([$usuario, $hash]);
    }

    public function findByUser($usuario) {
        $stmt = $this->db->prepare("SELECT * FROM Administrador WHERE usuario = ? AND eliminado = 0");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
