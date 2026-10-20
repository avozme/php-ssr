<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>
    <main>
        <h1>Iniciar sesión</h1>
        <?php if (isset($_GET['registered'])): ?>
            <p>Cuenta creada. Ya puedes iniciar sesión.</p>
        <?php endif; ?>
        <?php if ($this->error !== null): ?>
            <p role="alert"><?= htmlspecialchars($this->error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post" action="/?action=login">
            <label>
                Email
                <input type="email" name="email" required>
            </label>
            <label>
                Contraseña
                <input type="password" name="password" required>
            </label>
            <button type="submit">Iniciar sesión</button>
        </form>
    </main>
</body>
</html>
