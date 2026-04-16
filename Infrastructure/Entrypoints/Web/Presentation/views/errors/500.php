<?php
/** @var string|null $message */
?>
<h1>500 - Error</h1>
<p>Ocurrió un error inesperado.</p>
<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
