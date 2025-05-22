<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Registrar Nueva Venta</h2>

<?php if (!empty($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="index.php?controller=venta&action=create">
    <label for="cliente_id">Cliente (opcional):</label>
    <select name="cliente_id" id="cliente_id">
        <option value="">-- Sin datos --</option>
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['razon_social']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="tipo_venta">Tipo de Venta:</label>
    <select name="tipo_venta" id="tipo_venta" required onchange="toggleFechaEntrega()">
        <option value="recurrente">Recurrente</option>
        <option value="domingo">Domingo</option>
        <option value="contrato">Contrato</option>
    </select>

    <label for="fecha_entrega" id="label_fecha_entrega" style="display:none;">Fecha de Entrega (solo para contrato):</label>
    <input type="date" name="fecha_entrega" id="fecha_entrega" style="display:none;" />

    <h3>Productos</h3>
    <div id="productos-container">
        <div class="producto-row">
            <select name="productos[]" required>
                <option value="">-- Seleccione producto --</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo $producto['id']; ?>"><?php echo htmlspecialchars($producto['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="cantidades[]" min="1" value="1" required />
            <button type="button" onclick="removeProducto(this)">Eliminar</button>
        </div>
    </div>
    <button type="button" onclick="addProducto()">Agregar Producto</button>

    <br><br>
    <button type="submit">Registrar Venta</button>
</form>

<script>
function toggleFechaEntrega() {
    const tipo = document.getElementById('tipo_venta').value;
    const label = document.getElementById('label_fecha_entrega');
    const input = document.getElementById('fecha_entrega');
    if (tipo === 'contrato') {
        label.style.display = 'block';
        input.style.display = 'block';
        input.required = true;
    } else {
        label.style.display = 'none';
        input.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}

function addProducto() {
    const container = document.getElementById('productos-container');
    const div = document.createElement('div');
    div.className = 'producto-row';
    div.innerHTML = `
        <select name="productos[]" required>
            <option value="">-- Seleccione producto --</option>
            <?php foreach ($productos as $producto): ?>
                <option value="<?php echo $producto['id']; ?>"><?php echo htmlspecialchars($producto['nombre']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="cantidades[]" min="1" value="1" required />
        <button type="button" onclick="removeProducto(this)">Eliminar</button>
    `;
    container.appendChild(div);
}

function removeProducto(btn) {
    const div = btn.parentNode;
    div.parentNode.removeChild(div);
}

// Inicializar
toggleFechaEntrega();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
