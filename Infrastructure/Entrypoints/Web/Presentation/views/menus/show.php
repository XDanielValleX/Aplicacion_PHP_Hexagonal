<?php
/** @var string $basePath */
/** @var App\Infrastructure\Entrypoints\Web\Controllers\Dto\MenuRestauranteResponse $item */
?>
<h1>Detalle - Menú Restaurante</h1>

<ul>
    <li><strong>ID:</strong> <?= (int) $item->id ?></li>
    <li><strong>Plato:</strong> <?= htmlspecialchars($item->nombrePlato, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Restaurante:</strong> <?= htmlspecialchars($item->restaurante, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Precio:</strong> <?= htmlspecialchars($item->precio, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Cantidad:</strong> <?= (int) $item->cantidad ?></li>
    <li><strong>Duración:</strong> <?= (int) $item->duracion ?> min</li>
    <li><strong>Descripción:</strong> <?= htmlspecialchars($item->descripcion, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Cliente:</strong> <?= htmlspecialchars($item->cliente, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Mesero:</strong> <?= htmlspecialchars($item->mesero, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Mesa:</strong> <?= htmlspecialchars($item->mesa, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Comentarios:</strong> <?= htmlspecialchars($item->comentarios, ENT_QUOTES, 'UTF-8') ?></li>
    <li><strong>Evaluación:</strong> <?= (int) $item->evaluacion ?></li>
</ul>

<p>
    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.edit&id=<?= (int) $item->id ?>">Editar</a>
    <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.index">Volver</a>
</p>
