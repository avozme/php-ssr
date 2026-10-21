<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar publicación</title>
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>
    <main>
        <h1>Editar publicación</h1>
        <?php if ($this->error !== null): ?>
            <p role="alert"><?= htmlspecialchars($this->error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post" action="/?action=update-post&amp;id=<?= (int) $this->currentPost['id'] ?>">
            <label>Título <input name="titulo" required value="<?= htmlspecialchars($_POST['titulo'] ?? $this->currentPost['titulo'], ENT_QUOTES, 'UTF-8') ?>"></label>
            <label>Categoría <input name="categoria" required value="<?= htmlspecialchars($_POST['categoria'] ?? $this->currentPost['categoria'], ENT_QUOTES, 'UTF-8') ?>"></label>
            <label>Contenido <textarea name="cuerpo" required><?= htmlspecialchars($_POST['cuerpo'] ?? $this->currentPost['cuerpo'], ENT_QUOTES, 'UTF-8') ?></textarea></label>
            <button type="submit">Guardar cambios</button>
        </form>
    </main>
</body>
</html>
