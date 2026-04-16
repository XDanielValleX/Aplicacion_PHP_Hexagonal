<?php
/** @var string $basePath */
?>
<h1>Crear usuario</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <p>
        <label>Nombre</label><br>
        <input name="name" required>
    </p>

    <p>
        <label>Email</label><br>
        <input name="email" type="email" required>
    </p>

    <p>
        <label>Contraseña</label><br>
        <input name="password" type="password" required>
    </p>

    <p>
        <label>Rol (id)</label><br>
        <input name="role_id" type="number" min="1" value="1" required>
    </p>

    <p>
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.index">Volver</a>
    </p>
</form>
