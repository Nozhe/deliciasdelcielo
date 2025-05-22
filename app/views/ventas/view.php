<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Detalles de Venta #<?php echo $venta['id']; ?></h2>

<p><strong>Cliente:</strong> <?php echo htmlspecialchars($venta['razon_social'] ?? 'Sin datos'); ?></p>
<p><strong>Tipo de Venta:</strong> <?php echo htmlspecialchars($venta['tipo_venta']); ?></p>
<p><strong>Fecha y Hora:</strong> <?php echo $venta['fecha_hora']; ?></p>
<p><strong>Fecha de Entrega:</strong> <?php echo $venta['fecha_entrega'] ?? '-'; ?></p>
<p><strong>Total:</strong> $<?php echo number_format($venta['total'], 2); ?></p>

<h3>Productos Vendidos</h3>
<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($venta['productos'] as $prod): ?>
            <tr>
                <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                <td><?php echo $prod['cantidad']; ?></td>
                <td>$<?php echo number_format($prod['precio'], 2); ?></td>
                <td>$<?php echo number_format($prod['precio'] * $prod['cantidad'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php?controller=venta&action=index" class="btn">Volver a Ventas</a>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
