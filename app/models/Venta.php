<?php
require_once __DIR__ . '/../core/Database.php';

class Venta {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Crear venta y sus productos en transacción, descontando ingredientes
    public function create($cliente_id, $tipo_venta, $fecha_entrega, $productos) {
        try {
            $this->db->beginTransaction();

            // Calcular total
            $total = 0;
            $stmtPrecio = $this->db->prepare("SELECT precio FROM Producto WHERE id = ?");
            $stmtReceta = $this->db->prepare("SELECT ingrediente_id, cantidad_necesaria FROM Receta WHERE producto_id = ?");
            $stmtIngrediente = $this->db->prepare("SELECT stock_actual FROM Ingrediente WHERE id = ? FOR UPDATE");
            $stmtUpdateIngrediente = $this->db->prepare("UPDATE Ingrediente SET stock_actual = ? WHERE id = ?");

            foreach ($productos as $prod) {
                $stmtPrecio->execute([$prod['producto_id']]);
                $precio = $stmtPrecio->fetchColumn();
                $total += $precio * $prod['cantidad'];
            }

            $stmt = $this->db->prepare("INSERT INTO Venta (cliente_id, tipo_venta, fecha_entrega, total) VALUES (?, ?, ?, ?)");
            $stmt->execute([$cliente_id, $tipo_venta, $fecha_entrega ?: null, $total]);
            $venta_id = $this->db->lastInsertId();

            $stmtProd = $this->db->prepare("INSERT INTO VentaProducto (venta_id, producto_id, cantidad) VALUES (?, ?, ?)");

            foreach ($productos as $prod) {
                $stmtProd->execute([$venta_id, $prod['producto_id'], $prod['cantidad']]);

                $stmtProducto = $this->db->prepare("SELECT cantidad_por_receta FROM Producto WHERE id = ?");
                $stmtProducto->execute([$prod['producto_id']]);
                $cantidad_por_receta = $stmtProducto->fetchColumn() ?: 1;
            
                $stmtReceta->execute([$prod['producto_id']]);
                $recetas = $stmtReceta->fetchAll(PDO::FETCH_ASSOC);
            
                foreach ($recetas as $receta) {
                    $ingrediente_id = $receta['ingrediente_id'];
                    $cantidad_necesaria = $receta['cantidad_necesaria'];
            
                    $cantidad_a_descontar = ($cantidad_necesaria / $cantidad_por_receta) * $prod['cantidad'];
            
                    $stmtIngrediente->execute([$ingrediente_id]);
                    $stock_actual = $stmtIngrediente->fetchColumn();
            
                    if ($stock_actual === false) {
                        throw new Exception("Ingrediente con ID $ingrediente_id no encontrado.");
                    }
            
                    if ($stock_actual < $cantidad_a_descontar) {
                        throw new Exception("Stock insuficiente para ingrediente ID $ingrediente_id.");
                    }
            
                    $nuevo_stock = $stock_actual - $cantidad_a_descontar;
            
                    $stmtUpdateIngrediente->execute([$nuevo_stock, $ingrediente_id]);
                }
            }
            

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            // Opcional: loguear error $e->getMessage()
            return false;
        }
    }


    public function getAll() {
        $stmt = $this->db->query("SELECT v.*, c.razon_social FROM Venta v LEFT JOIN Cliente c ON v.cliente_id = c.id WHERE v.eliminado = 0 ORDER BY v.fecha_hora DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT v.*, c.razon_social FROM Venta v LEFT JOIN Cliente c ON v.cliente_id = c.id WHERE v.id = ? AND v.eliminado = 0");
        $stmt->execute([$id]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$venta) return null;

        $stmtProd = $this->db->prepare("SELECT vp.*, p.nombre, p.precio FROM VentaProducto vp JOIN Producto p ON vp.producto_id = p.id WHERE vp.venta_id = ?");
        $stmtProd->execute([$id]);
        $productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

        $venta['productos'] = $productos;
        return $venta;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE Venta SET eliminado = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
