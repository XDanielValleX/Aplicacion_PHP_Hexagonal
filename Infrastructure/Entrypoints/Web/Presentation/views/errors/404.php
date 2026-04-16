<?php
/** @var string|null $route */
?>
<h1>404 - No encontrado</h1>
<p>La ruta solicitada no existe<?= $route ? ': ' . htmlspecialchars($route, ENT_QUOTES, 'UTF-8') : '' ?>.</p>
