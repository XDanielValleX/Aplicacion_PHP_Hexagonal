<?php
/** @var string $basePath */
/** @var App\Infrastructure\Entrypoints\Web\Controllers\Dto\UserResponse[] $users */
?>
<h1>Usuarios</h1>

<p>
    <a class="btn primary" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.create">Crear usuario</a>
</p>

<?php if (empty($users)): ?>
    <p>No hay usuarios.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= (int) $u->id ?></td>
                <td><?= htmlspecialchars($u->name, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($u->email, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) $u->roleId ?></td>
                <td><?= htmlspecialchars($u->status, ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.show&id=<?= (int) $u->id ?>">Ver</a>
                    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.edit&id=<?= (int) $u->id ?>">Editar</a>
                    <form class="inline" method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=users.destroy">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id" value="<?= (int) $u->id ?>">
                        <button class="btn" type="submit" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
