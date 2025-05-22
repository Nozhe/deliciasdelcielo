<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Productos</h2>

<a href="index.php?controller=producto&action=create" class="btn">Agregar Producto</a>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Precio</th>
            <th>Cantidad fija domingo</th>
            <th>Acciones</th>
            <th>Receta</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo htmlspecialchars($producto['tipo']); ?></td>
                <td><?php echo number_format($producto['precio'], 2). ' Bs.'; ?></td>
                <td><?php echo $producto['cantidad_fija_domingo'] !== null ? htmlspecialchars($producto['cantidad_fija_domingo']) : '-'; ?></td>
                <td>
                    <a href="index.php?controller=producto&action=edit&id=<?php echo $producto['id']; ?>" class="btn btn-secondary">Editar</a>
                    <a href="index.php?controller=producto&action=delete&id=<?php echo $producto['id']; ?>" 
                    class="btn btn-danger" 
                    onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
                </td>
                <td>
                    <a href="index.php?controller=receta&action=index&producto_id=<?php echo $producto['id']; ?>" class="btn">Administrar Receta</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
