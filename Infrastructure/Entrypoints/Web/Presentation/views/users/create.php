<?php
/** @var string $basePath */
/** @var array<string, mixed> $old */
?>
<h1>Crear usuario</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="role_id" value="1">

    <p>
        <label>Nombre</label><br>
        <input name="name" required value="<?= htmlspecialchars((string) ($old['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        <label>Email</label><br>
        <input name="email" type="email" required value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        <label>Contraseña</label><br>
        <input name="password" type="password" required>
    </p>

    <p>
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.index">Volver</a>
    </p>
</form>
