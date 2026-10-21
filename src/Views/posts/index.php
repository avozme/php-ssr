<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicaciones</title>
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>
    <main>
        <h1>Publicaciones</h1>
        <form method="get" action="/">
            <input type="hidden" name="action" value="posts">
            <label>
                Buscar por título o categoría
                <input type="search" name="q" value="<?= htmlspecialchars($term, ENT_QUOTES, 'UTF-8') ?>">
            </label>
            <button type="submit">Buscar</button>
        </form>
        <?php if (isset($_SESSION['id'])): ?>
            <p><a href="/?action=create-post">Crear publicación</a></p>
        <?php endif; ?>
        <?php if ($posts === null): ?>
            <p>No hay publicaciones.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <a href="/?action=post&amp;id=<?= (int) $post['id'] ?>"><?= htmlspecialchars($post['titulo'], ENT_QUOTES, 'UTF-8') ?></a>
                        — <?= htmlspecialchars($post['categoria'], ENT_QUOTES, 'UTF-8') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>
</html>
