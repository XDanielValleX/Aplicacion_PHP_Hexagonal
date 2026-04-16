<?php
/** @var string $basePath */
?>
<h1>Recuperar contraseña</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.send-reset">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <p>
        <label>Email</label><br>
        <input name="email" type="email" required>
    </p>

    <p>
        <button class="btn primary" type="submit">Enviar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.login">Volver</a>
    </p>
</form>
