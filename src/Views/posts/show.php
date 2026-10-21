<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($this->currentPost['titulo'], ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>
    <main>
        <h1><?= htmlspecialchars($this->currentPost['titulo'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Categoría: <?= htmlspecialchars($this->currentPost['categoria'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><?= nl2br(htmlspecialchars($this->currentPost['cuerpo'], ENT_QUOTES, 'UTF-8')) ?></p>
        <?php if (isset($_SESSION['id']) && (int) $this->currentPost['usuario_id'] === (int) $_SESSION['id']): ?>
            <a href="/?action=edit-post&amp;id=<?= (int) $this->currentPost['id'] ?>">Editar</a>
            <form method="post" action="/?action=delete-post&amp;id=<?= (int) $this->currentPost['id'] ?>">
                <button type="submit">Eliminar</button>
            </form>
        <?php endif; ?>
        <p><a href="/?action=posts">Volver a publicaciones</a></p>
    </main>
</body>
</html>
