<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Inventario de Ingredientes</h2>

<a href="index.php?controller=ingrediente&action=create" class="btn">Agregar Ingrediente</a>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Stock Actual</th>
            <th>Unidad de medida (receta)</th>
            <th>Unidad de compra</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ingredientes as $ing): ?>
            <?php
            // Convertir stock base a unidad de compra para mostrar
            $stock_mostrar = $ing['stock_actual'] / $ing['factor_conversion'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($ing['nombre']); ?></td>
                <td><?php echo round($stock_mostrar, 4); ?></td>
                <td><?php echo htmlspecialchars($ing['unidad_medida']); ?></td>
                <td><?php echo ucfirst(htmlspecialchars($ing['unidad_compra'])); ?></td>
                <td>
                    <a href="index.php?controller=ingrediente&action=edit&id=<?php echo $ing['id']; ?>" class="btn btn-secondary">Editar</a>
                    <a href="index.php?controller=ingrediente&action=delete&id=<?php echo $ing['id']; ?>" 
                    class="btn btn-danger" 
                    onclick="return confirm('¿Eliminar este ingrediente?');">Eliminar</a>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
