<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>
    <main>
        <h1>Crear cuenta</h1>
        <?php if ($this->error !== null): ?>
            <p role="alert"><?= htmlspecialchars($this->error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post" action="/?action=register">
            <label>
                Nombre
                <input type="text" name="nombre" required>
            </label>
            <label>
                Email
                <input type="email" name="email" required>
            </label>
            <label>
                Contraseña
                <input type="password" name="password" required>
            </label>
            <button type="submit">Registrarse</button>
        </form>
    </main>
</body>
</html>
