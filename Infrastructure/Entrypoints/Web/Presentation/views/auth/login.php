<?php
/** @var string $basePath */
?>
<h1>Login</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.authenticate">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <p>
        <label>Email</label><br>
        <input name="email" type="email" required>
    </p>

    <p>
        <label>Contraseña</label><br>
        <input name="password" type="password" required>
    </p>

    <p>
        <button class="btn primary" type="submit">Entrar</button>
    </p>
</form>

<p>
    <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.forgot">¿Olvidaste tu contraseña?</a>
</p>

<p>
    <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.create">Crear usuario</a>
</p>
