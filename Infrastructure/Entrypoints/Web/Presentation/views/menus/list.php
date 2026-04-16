<?php
/** @var string $basePath */
/** @var App\Infrastructure\Entrypoints\Web\Controllers\Dto\MenuRestauranteResponse[] $items */
?>
<h1>Menú Restaurante</h1>

<p>
    <a class="btn primary" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.create">Crear registro</a>
</p>

<?php if (empty($items)): ?>
    <p>No hay registros.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Plato</th>
            <th>Restaurante</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Evaluación</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $i): ?>
            <tr>
                <td><?= (int) $i->id ?></td>
                <td><?= htmlspecialchars($i->nombrePlato, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($i->restaurante, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($i->precio, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) $i->cantidad ?></td>
                <td><?= (int) $i->evaluacion ?></td>
                <td>
                    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.show&id=<?= (int) $i->id ?>">Ver</a>
                    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.edit&id=<?= (int) $i->id ?>">Editar</a>
                    <form class="inline" method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.destroy">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id" value="<?= (int) $i->id ?>">
                        <button class="btn" type="submit" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
