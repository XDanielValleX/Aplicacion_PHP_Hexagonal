<?php
/** @var string $basePath */
/** @var array<string, mixed> $old */
?>
<h1>Recuperar contraseña</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.send-reset">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <p>
        <label>Email</label><br>
        <input name="email" type="email" required value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        <button class="btn primary" type="submit">Enviar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.login">Volver</a>
    </p>
</form>
