<?php
/** @var string $name */
/** @var string $tempPassword */
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Recuperación de contraseña</title>
</head>
<body>
    <h2>Recuperación de contraseña</h2>

    <p>Hola <strong><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></strong>,</p>

    <p>Tu contraseña temporal es:</p>

    <p style="font-size: 18px;"><strong><?= htmlspecialchars($tempPassword, ENT_QUOTES, 'UTF-8') ?></strong></p>

    <p>Por seguridad, inicia sesión y cambia tu contraseña lo antes posible.</p>
</body>
</html>
