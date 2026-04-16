<?php
/** @var string $basePath */
/** @var array<string, mixed> $old */

$evaluacion = (int) ($old['evaluacion'] ?? 1);
?>
<h1>Crear registro - Menú Restaurante</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <p><label>Nombre del plato</label><br><input name="nombrePlato" required value="<?= htmlspecialchars((string) ($old['nombrePlato'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Restaurante</label><br><input name="restaurante" required value="<?= htmlspecialchars((string) ($old['restaurante'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Precio</label><br><input name="precio" type="number" step="0.01" min="0" required value="<?= htmlspecialchars((string) ($old['precio'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Cantidad</label><br><input name="cantidad" type="number" min="1" required value="<?= htmlspecialchars((string) ($old['cantidad'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Duración (min)</label><br><input name="duracion" type="number" min="0" required value="<?= htmlspecialchars((string) ($old['duracion'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Descripción</label><br><textarea name="descripcion" rows="3"><?= htmlspecialchars((string) ($old['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea></p>
    <p><label>Cliente</label><br><input name="cliente" required value="<?= htmlspecialchars((string) ($old['cliente'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Mesero</label><br><input name="mesero" required value="<?= htmlspecialchars((string) ($old['mesero'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Mesa</label><br><input name="mesa" required value="<?= htmlspecialchars((string) ($old['mesa'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></p>
    <p><label>Comentarios</label><br><textarea name="comentarios" rows="3"><?= htmlspecialchars((string) ($old['comentarios'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea></p>

    <p>
        <label>Evaluación</label><br>
        <select name="evaluacion" required>
            <?php for ($n = 1; $n <= 5; $n++): ?>
                <option value="<?= $n ?>" <?= $evaluacion === $n ? 'selected' : '' ?>><?= $n ?></option>
            <?php endfor; ?>
        </select>
    </p>

    <p>
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.index">Volver</a>
    </p>
</form>
