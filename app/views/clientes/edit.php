<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Editar Cliente Recurrente</h2>

<form method="POST" action="index.php?controller=cliente&action=edit&id=<?php echo $cliente['id']; ?>">
    <label for="razon_social">Razón Social:</label>
    <input type="text" name="razon_social" id="razon_social" value="<?php echo htmlspecialchars($cliente['razon_social']); ?>" required />

    <label for="carnet_identidad_o_nit">Carnet de Identidad o NIT (opcional):</label>
    <input type="text" name="carnet_identidad_o_nit" id="carnet_identidad_o_nit" value="<?php echo htmlspecialchars($cliente['carnet_identidad_o_nit'] ?? ''); ?>" />

    <button type="submit">Actualizar</button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
