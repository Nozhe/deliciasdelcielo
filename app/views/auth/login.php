<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login - Delicias del Cielo</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="login-container">
    <h2>Login Administrador</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?controller=auth&action=login">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required />
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required />
        <button type="submit" class="btn">Entrar</button>
    </form>
</div>

</body>
</html>
