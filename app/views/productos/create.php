<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Agregar Producto</h2>

<form method="POST" action="index.php?controller=producto&action=create">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required />

    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" required onchange="toggleCantidadDomingo()">
        <option value="recurrente">Recurrente</option>
        <option value="tienda">Tienda</option>
        <option value="contrato">Contrato</option>
    </select>

    <label for="precio">Precio:</label>
    <input type="number" step="0.01" name="precio" id="precio" required />

    <label for="cantidad_fija_domingo">Cantidad fija domingo (solo para tipo tienda - bizcochos):</label>
    <input type="number" name="cantidad_fija_domingo" id="cantidad_fija_domingo" min="0" />

    <label for="cantidad_por_receta">Cantidad de producto que produce la receta:</label>
    <input type="number" min="1" name="cantidad_por_receta" id="cantidad_por_receta" value="1" required />

    <button type="submit" class="btn">Guardar</button>
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
