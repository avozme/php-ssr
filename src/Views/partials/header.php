<header>
    <nav>
        <a href="/">Inicio</a>
        <?php if (isset($_SESSION['id'], $_SESSION['email'])): ?>
            <span><?= htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?></span>
            <a href="/?action=logout">Cerrar sesión</a>
        <?php else: ?>
            <a href="/?action=login">Iniciar sesión</a>
            <a href="/?action=register">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>
