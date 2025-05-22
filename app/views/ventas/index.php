<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Ventas Registradas</h2>

<a href="index.php?controller=venta&action=create" class="btn">Registrar Venta</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Tipo Venta</th>
            <th>Fecha y Hora</th>
            <th>Fecha Entrega</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ventas as $venta): ?>
            <tr>
                <td><?php echo $venta['id']; ?></td>
                <td><?php echo htmlspecialchars($venta['razon_social'] ?? 'Sin datos'); ?></td>
                <td><?php echo htmlspecialchars($venta['tipo_venta']); ?></td>
                <td><?php echo $venta['fecha_hora']; ?></td>
                <td><?php echo $venta['fecha_entrega'] ?? '-'; ?></td>
                <td><?php echo number_format($venta['total'], 2). ' Bs.'; ?></td>
                <td>
                    <a href="index.php?controller=venta&action=view&id=<?php echo $venta['id']; ?>" class="btn btn-secondary">Detalles</a>
                    <a href="index.php?controller=venta&action=delete&id=<?php echo $venta['id']; ?>" 
                    class="btn btn-danger" 
                    onclick="return confirm('¿Eliminar esta venta?');">
                    Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
