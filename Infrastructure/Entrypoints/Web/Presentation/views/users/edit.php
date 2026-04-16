<?php
/** @var string $basePath */
/** @var App\Infrastructure\Entrypoints\Web\Controllers\Dto\UserResponse $user */
?>
<h1>Editar usuario</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.update">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="id" value="<?= (int) $user->id ?>">

    <p>
        <label>Nombre</label><br>
        <input name="name" required value="<?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        <label>Email</label><br>
        <input name="email" type="email" required value="<?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        <label>Nueva contraseña (opcional)</label><br>
        <input name="password" type="password" placeholder="(dejar vacío para no cambiar)">
    </p>

    <p>
        <label>Rol (id)</label><br>
        <input name="role_id" type="number" min="1" required value="<?= (int) $user->roleId ?>">
    </p>

    <p>
        <label>Estado</label><br>
        <select name="status" required>
            <option value="ACTIVE" <?= $user->status === 'ACTIVE' ? 'selected' : '' ?>>ACTIVE</option>
            <option value="INACTIVE" <?= $user->status === 'INACTIVE' ? 'selected' : '' ?>>INACTIVE</option>
        </select>
    </p>

    <p>
        <button class="btn primary" type="submit">Actualizar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.index">Volver</a>
    </p>
</form>
