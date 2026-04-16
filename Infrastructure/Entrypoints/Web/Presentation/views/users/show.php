<?php
/** @var string $basePath */
/** @var App\Infrastructure\Entrypoints\Web\Controllers\Dto\UserResponse $user */
?>
<h1>Detalle usuario</h1>

<ul>
    <li><strong>ID:</strong> <?= (int) $user->id ?></li>
    <li><strong>Nombre:</strong> <?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Email:</strong> <?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Rol:</strong> <?= (int) $user->roleId ?></li>
    <li><strong>Estado:</strong> <?= htmlspecialchars($user->status, ENT_QUOTES, 'UTF-8') ?></li>
</ul>

<p>
    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.edit&id=<?= (int) $user->id ?>">Editar</a>
    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.index">Volver</a>
</p>
