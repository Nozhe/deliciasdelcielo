<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Clientes Recurrentes</h2>

<a href="index.php?controller=cliente&action=create" class="btn">Agregar Cliente</a>

<table>
    <thead>
        <tr>
            <th>Razón Social</th>
            <th>Carnet o NIT</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                <td><?php echo htmlspecialchars($cliente['carnet_identidad_o_nit'] ?? ''); ?></td>
                <td>
                    <a href="index.php?controller=cliente&action=edit&id=<?php echo $cliente['id']; ?>" class="btn btn-secondary">Editar</a>
                    <a href="index.php?controller=cliente&action=delete&id=<?php echo $cliente['id']; ?>" 
                    class="btn btn-danger" 
                    onclick="return confirm('¿Eliminar este cliente?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
