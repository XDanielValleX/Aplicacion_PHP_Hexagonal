<?php
/** @var string $basePath */
?>
<h1>Crear registro - Menú Restaurante</h1>

<form method="post" action="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <p><label>Nombre del plato</label><br><input name="nombrePlato" required></p>
    <p><label>Restaurante</label><br><input name="restaurante" required></p>
    <p><label>Precio</label><br><input name="precio" type="number" step="0.01" min="0" required></p>
    <p><label>Cantidad</label><br><input name="cantidad" type="number" min="1" required></p>
    <p><label>Duración (min)</label><br><input name="duracion" type="number" min="0" required></p>
    <p><label>Descripción</label><br><textarea name="descripcion" rows="3"></textarea></p>
    <p><label>Cliente</label><br><input name="cliente" required></p>
    <p><label>Mesero</label><br><input name="mesero" required></p>
    <p><label>Mesa</label><br><input name="mesa" required></p>
    <p><label>Comentarios</label><br><textarea name="comentarios" rows="3"></textarea></p>

    <p>
        <label>Evaluación</label><br>
        <select name="evaluacion" required>
            <?php for ($n = 1; $n <= 5; $n++): ?>
                <option value="<?= $n ?>"><?= $n ?></option>
            <?php endfor; ?>
        </select>
    </p>

    <p>
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn" href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8') ?>/index.php?route=menus.index">Volver</a>
    </p>
</form>
