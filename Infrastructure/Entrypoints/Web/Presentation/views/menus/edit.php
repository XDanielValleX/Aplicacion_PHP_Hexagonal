<?php
/** @var string $basePath */
/** @var array<string, mixed> $old */
/** @var App\Infrastructure\Entrypoints\Web\Controllers\Dto\MenuRestauranteResponse $item */

$nombrePlato = (string) ($old['nombrePlato'] ?? $item->nombrePlato);
$restaurante = (string) ($old['restaurante'] ?? $item->restaurante);
$precio = (string) ($old['precio'] ?? $item->precio);
$cantidad = (string) ($old['cantidad'] ?? (string) $item->cantidad);
$duracion = (string) ($old['duracion'] ?? (string) $item->duracion);
$descripcion = (string) ($old['descripcion'] ?? $item->descripcion);
$cliente = (string) ($old['cliente'] ?? $item->cliente);
$mesero = (string) ($old['mesero'] ?? $item->mesero);
$mesa = (string) ($old['mesa'] ?? $item->mesa);
$comentarios = (string) ($old['comentarios'] ?? $item->comentarios);
$evaluacion = (int) ($old['evaluacion'] ?? $item->evaluacion);
?>
<h1>Editar registro - Menú Restaurante</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.update">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="id" value="<?= (int) $item->id ?>">

    <p><label>Nombre del plato</label><br><input name="nombrePlato" required value="<?= htmlspecialchars($nombrePlato, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Restaurante</label><br><input name="restaurante" required value="<?= htmlspecialchars($restaurante, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Precio</label><br><input name="precio" type="number" step="0.01" min="0" required value="<?= htmlspecialchars($precio, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Cantidad</label><br><input name="cantidad" type="number" min="1" required value="<?= htmlspecialchars($cantidad, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Duración (min)</label><br><input name="duracion" type="number" min="0" required value="<?= htmlspecialchars($duracion, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Descripción</label><br><textarea name="descripcion" rows="3"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?></textarea></p>
    <p><label>Cliente</label><br><input name="cliente" required value="<?= htmlspecialchars($cliente, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Mesero</label><br><input name="mesero" required value="<?= htmlspecialchars($mesero, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Mesa</label><br><input name="mesa" required value="<?= htmlspecialchars($mesa, ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Comentarios</label><br><textarea name="comentarios" rows="3"><?= htmlspecialchars($comentarios, ENT_QUOTES, 'UTF-8') ?></textarea></p>

    <p>
        <label>Evaluación</label><br>
        <select name="evaluacion" required>
            <?php for ($n = 1; $n <= 5; $n++): ?>
                <option value="<?= $n ?>" <?= $evaluacion === $n ? 'selected' : '' ?>><?= $n ?></option>
            <?php endfor; ?>
        </select>
    </p>

    <p>
        <button class="btn primary" type="submit">Actualizar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.index">Volver</a>
    </p>
</form>
