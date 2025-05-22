<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Agregar Ingrediente</h2>

<form method="POST" action="index.php?controller=ingrediente&action=create">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required />

    <label for="stock_actual">Stock Actual (en unidad de compra):</label>
    <input type="number" step="0.0001" min="0" name="stock_actual" id="stock_actual" required />

    <label for="unidad_medida">Unidad de medida para receta (ej. gramos, ml, unidades):</label>
    <input type="text" name="unidad_medida" id="unidad_medida" required />

    <label for="unidad_compra">Unidad de compra:</label>
    <select name="unidad_compra" id="unidad_compra" required>
        <option value="gramo">Gramo</option>
        <option value="kilogramo">Kilogramo</option>
        <option value="quintal">Quintal</option>
        <option value="mililitro">Mililitro</option>
        <option value="litro">Litro</option>
        <option value="unidad">Unidad</option>
    </select>

    <button type="submit" class="btn">Guardar</button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
