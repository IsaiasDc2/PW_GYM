<?php
$titulo_pagina = $titulo_pagina ?? 'Gestión de clases - Forja Gym';
$pagina_activa = $pagina_activa ?? 'panel';
require_once __DIR__ . '/../../../includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1 class="h2 mb-4">Administración de clases</h1>
        <?php if (isset($mensajes[$status])): ?>
            <div class="notice <?php echo $status === 'error' ? 'notice-error' : 'notice-success'; ?>" role="status"><?php echo e($mensajes[$status]); ?></div>
        <?php endif; ?>
        <p>
            <a href="crear.php" class="btn btn-primary">Agregar nueva clase</a>
            <a href="../admin_panel.php" class="btn btn-ghost">Volver al panel</a>
        </p>
        <div class="table-responsive">
            <table class="table table-dark table-bordered table-striped align-middle">
                <thead>
                    <tr><th>ID</th><th>Clase</th><th>Categoría</th><th>Instructor</th><th>Sede</th><th>Día</th><th>Hora</th><th>Cupo</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                <?php foreach ($registros as $item): ?>
                    <tr>
                        <td><?php echo e($item['id']); ?></td>
                        <td><?php echo e($item['nombre']); ?></td>
                        <td><?php echo e($item['categoria']); ?></td>
                        <td><?php echo e($item['instructor']); ?></td>
                        <td><?php echo e($item['sede']); ?></td>
                        <td><?php echo e($item['dia_semana']); ?></td>
                        <td><?php echo e(substr($item['hora'], 0, 5)); ?></td>
                        <td><?php echo e($item['cupo']); ?></td>
                        <td class="text-nowrap">
                            <a href="editar.php?id=<?php echo e($item['id']); ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form method="post" action="eliminar.php" class="d-inline" data-confirm="¿Confirma eliminar este registro?">
                                <?php echo csrf_campo(); ?>
                                <input type="hidden" name="id" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$registros): ?>
                    <tr><td colspan="9" class="text-center">No hay clases cargadas.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
