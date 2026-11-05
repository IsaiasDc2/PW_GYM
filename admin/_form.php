<?php
$select = function (string $campo, string $etiqueta, array $opciones) use ($datos, $errores) {
    echo '<div class="field col-md-6"><label for="' . e($campo) . '">' . e($etiqueta) . '</label>';
    echo '<select id="' . e($campo) . '" name="' . e($campo) . '" required><option value="">Seleccionar...</option>';
    foreach ($opciones as $op) {
        $sel = (string) $op['id'] === (string) $datos[$campo] ? ' selected' : '';
        echo '<option value="' . e($op['id']) . '"' . $sel . '>' . e($op['nombre']) . '</option>';
    }
    echo '</select>';
    if (isset($errores[$campo])) {
        echo '<span class="field-error">' . e($errores[$campo]) . '</span>';
    }
    echo '</div>';
};
?>
<?php if ($errores): ?>
    <div class="notice notice-error" role="alert">Revisá los datos: <?php echo count($errores); ?> error(es).</div>
<?php endif; ?>
<form class="form card" method="post" novalidate>
    <?php echo csrf_campo(); ?>
    <div class="row g-3">
        <div class="field col-12">
            <label for="nombre">Nombre de la clase</label>
            <input type="text" id="nombre" name="nombre" maxlength="60" value="<?php echo e($datos['nombre']); ?>" required>
            <?php if (isset($errores['nombre'])): ?><span class="field-error"><?php echo e($errores['nombre']); ?></span><?php endif; ?>
        </div>
        <?php
        $select('categoria_id', 'Categoría', $catalogos['categorias']);
        $select('instructor_id', 'Instructor', $catalogos['instructores']);
        $select('sede_id', 'Sede', $catalogos['sedes']);
        ?>
        <div class="field col-md-6">
            <label for="dia_semana">Día</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="">Seleccionar...</option>
                <?php foreach (DIAS_SEMANA as $dia): ?>
                    <option value="<?php echo e($dia); ?>"<?php echo $datos['dia_semana'] === $dia ? ' selected' : ''; ?>><?php echo e($dia); ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['dia_semana'])): ?><span class="field-error"><?php echo e($errores['dia_semana']); ?></span><?php endif; ?>
        </div>
        <div class="field col-md-6">
            <label for="hora">Hora</label>
            <input type="time" id="hora" name="hora" value="<?php echo e($datos['hora']); ?>" required>
            <?php if (isset($errores['hora'])): ?><span class="field-error"><?php echo e($errores['hora']); ?></span><?php endif; ?>
        </div>
        <div class="field col-md-6">
            <label for="cupo">Cupo</label>
            <input type="number" id="cupo" name="cupo" min="1" max="200" value="<?php echo e($datos['cupo']); ?>" required>
            <?php if (isset($errores['cupo'])): ?><span class="field-error"><?php echo e($errores['cupo']); ?></span><?php endif; ?>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a class="btn btn-ghost" href="index.php">Cancelar</a>
    </div>
</form>
