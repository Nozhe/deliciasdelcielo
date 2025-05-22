<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Editar Ingrediente</h2>

<form method="POST" action="index.php?controller=ingrediente&action=edit&id=<?php echo $ingrediente['id']; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($ingrediente['nombre']); ?>" required />

    <label for="stock_actual">Stock Actual (en unidad de compra):</label>
    <input type="number" step="0.0001" min="0" name="stock_actual" id="stock_actual" value="<?php echo htmlspecialchars($ingrediente['stock_mostrar']); ?>" required />

    <label for="unidad_medida">Unidad de medida para receta (ej. gramos, ml, unidades):</label>
    <input type="text" name="unidad_medida" id="unidad_medida" value="<?php echo htmlspecialchars($ingrediente['unidad_medida']); ?>" required />

    <label for="unidad_compra">Unidad de compra:</label>
    <select name="unidad_compra" id="unidad_compra" required>
        <?php
        $unidades = ['gramo', 'kilogramo', 'quintal', 'mililitro', 'litro', 'unidad'];
        foreach ($unidades as $unidad) {
            $selected = ($unidad == $ingrediente['unidad_compra']) ? 'selected' : '';
            echo "<option value=\"$unidad\" $selected>" . ucfirst($unidad) . "</option>";
        }
        ?>
    </select>

    <button type="submit" class="btn">Actualizar</button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
