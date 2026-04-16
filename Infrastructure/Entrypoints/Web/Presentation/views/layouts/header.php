<?php
/** @var string $basePath */
/** @var array<int, array{type: string, message: string}> $flash */
?><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Actividad 1</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; margin: 0; padding: 0; }
        header, nav, main, footer { padding: 16px; }
        nav a { margin-right: 12px; }
        .flash { padding: 10px 12px; margin: 12px 0; border-radius: 6px; }
        .flash.success { background: #e8f5e9; border: 1px solid #2e7d32; }
        .flash.error { background: #ffebee; border: 1px solid #c62828; }
        .container { max-width: 980px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; }
        input, select { padding: 8px; width: 100%; max-width: 420px; }
        form.inline { display: inline; }
        .btn { display: inline-block; padding: 8px 12px; border: 1px solid #333; background: #fff; cursor: pointer; text-decoration: none; }
        .btn.primary { background: #111; color: #fff; }
    </style>
</head>
<body>
<div class="container">
<header>
    <h2>Actividad 1 - PHP (Hexagonal + DDD)</h2>
</header>

<?php foreach (($flash ?? []) as $msg): ?>
    <div class="flash <?= htmlspecialchars($msg['type'], ENT_QUOTES, 'UTF-8') ?>">
        <?= htmlspecialchars($msg['message'], ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endforeach; ?>
