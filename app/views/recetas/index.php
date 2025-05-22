<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Receta para el producto: <?php echo htmlspecialchars($producto['nombre']); ?></h2>

<h3>Ingredientes en la receta</h3>

<table>
    <thead>
        <tr>
            <th>Ingrediente</th>
            <th>Cantidad necesaria</th>
            <th>Unidad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recetas as $receta): ?>
            <tr>
                <td><?php echo htmlspecialchars($receta['ingrediente_nombre']); ?></td>
                <td>
                    <form method="POST" action="index.php?controller=receta&action=edit" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $receta['id']; ?>" />
                        <input type="number" step="0.01" name="cantidad_necesaria" value="<?php echo htmlspecialchars($receta['cantidad_necesaria']); ?>" required style="width:80px;" />
                </td>
                <td><?php echo htmlspecialchars($receta['unidad_medida']); ?></td>
                <td>
                    <button class="btn" type="submit">Actualizar</button>
                    </form>
                    <a href="index.php?controller=receta&action=delete&id=<?php echo $receta['id']; ?>&producto_id=<?php echo $producto['id']; ?>"
                    class="btn-danger"
                    onclick="return confirm('¿Eliminar este ingrediente de la receta?');">
                    Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Agregar ingrediente a la receta</h3>

<form method="POST" action="index.php?controller=receta&action=create">
    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>" />
    <label for="ingrediente_id">Ingrediente:</label>
    <select name="ingrediente_id" id="ingrediente_id" required>
        <option value="">-- Seleccione ingrediente --</option>
        <?php foreach ($ingredientes as $ingrediente): ?>
            <option value="<?php echo $ingrediente['id']; ?>"><?php echo htmlspecialchars($ingrediente['nombre']); ?> (<?php echo htmlspecialchars($ingrediente['unidad_medida']); ?>)</option>
        <?php endforeach; ?>
    </select>

    <label for="cantidad_necesaria">Cantidad necesaria:</label>
    <input type="number" step="0.01" name="cantidad_necesaria" id="cantidad_necesaria" required />

    <button class="btn" type="submit">Agregar</button>
</form>

<br>
<a href="index.php?controller=producto&action=index" class="btn">Volver a Productos</a>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
