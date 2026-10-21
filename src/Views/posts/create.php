<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva publicación</title>
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>
    <main>
        <h1>Nueva publicación</h1>
        <?php if ($this->error !== null): ?>
            <p role="alert"><?= htmlspecialchars($this->error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post" action="/?action=store-post">
            <label>Título <input name="titulo" required value="<?= htmlspecialchars($_POST['titulo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></label>
            <label>Categoría <input name="categoria" required value="<?= htmlspecialchars($_POST['categoria'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></label>
            <label>Contenido <textarea name="cuerpo" required><?= htmlspecialchars($_POST['cuerpo'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea></label>
            <button type="submit">Publicar</button>
        </form>
    </main>
</body>
</html>
