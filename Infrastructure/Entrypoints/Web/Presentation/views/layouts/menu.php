<?php
/** @var array{id:int,name:string,email:string,role:int}|null $auth */
/** @var string $basePath */
?>
<nav>
    <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=home">Inicio</a>

    <?php if (!empty($auth)): ?>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.index">Usuarios</a>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.index">Menú Restaurante</a>
        <strong><?= htmlspecialchars($auth['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        <form class="inline" method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.logout">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <button class="btn" type="submit">Cerrar sesión</button>
        </form>
    <?php else: ?>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.login">Login</a>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.forgot">Recuperar</a>
    <?php endif; ?>
</nav>
<main>
