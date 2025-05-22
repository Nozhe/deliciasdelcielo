<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Editar Producto</h2>

<form method="POST" action="index.php?controller=producto&action=edit&id=<?php echo $producto['id']; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required />

    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" required onchange="toggleCantidadDomingo()">
        <option value="recurrente" <?php if($producto['tipo'] === 'recurrente') echo 'selected'; ?>>Recurrente</option>
        <option value="tienda" <?php if($producto['tipo'] === 'tienda') echo 'selected'; ?>>Tienda</option>
        <option value="contrato" <?php if($producto['tipo'] === 'contrato') echo 'selected'; ?>>Contrato</option>
    </select>

    <label for="precio">Precio:</label>
    <input type="number" step="0.01" name="precio" id="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required />

    <label for="cantidad_fija_domingo">Cantidad fija domingo (solo para tipo tienda - bizcochos):</label>
    <input type="number" name="cantidad_fija_domingo" id="cantidad_fija_domingo" min="0" value="<?php echo htmlspecialchars($producto['cantidad_fija_domingo']); ?>" />

    <label for="cantidad_por_receta">Cantidad de producto que produce la receta:</label>
    <input type="number" min="1" name="cantidad_por_receta" id="cantidad_por_receta" value="<?php echo htmlspecialchars($producto['cantidad_por_receta']); ?>" required />

    <button type="submit" class="btn">Actualizar</button>
</form>

<script>
function toggleCantidadDomingo() {
    const tipo = document.getElementById('tipo').value;
    const cantidadDomingo = document.getElementById('cantidad_fija_domingo');
    if (tipo === 'tienda') {
        cantidadDomingo.disabled = false;
    } else {
        cantidadDomingo.value = '';
        cantidadDomingo.disabled = true;
    }
}
// Inicializar estado
toggleCantidadDomingo();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
