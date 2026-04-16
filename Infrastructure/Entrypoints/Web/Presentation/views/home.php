<?php
/** @var array{id:int,name:string,email:string,role:int}|null $auth */
/** @var string $basePath */
?>
<h1>Inicio</h1>

<?php if (!empty($auth)): ?>
    <p>Sesión iniciada como <strong><?= htmlspecialchars($auth['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>.</p>
<?php else: ?>
    <p>Bienvenido. Inicia sesión para continuar.</p>
    <a class="btn primary" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=auth.login">Ir a Login</a>
<?php endif; ?>
