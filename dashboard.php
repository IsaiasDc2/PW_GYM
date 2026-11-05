<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/config/conexion.php';

$stmt = $pdo->prepare(
    'SELECT c.nombre AS clase, c.dia_semana, c.hora, s.nombre AS sede, r.fecha, r.estado
     FROM reservas r
     INNER JOIN clases c ON c.id = r.clase_id
     INNER JOIN sedes s ON s.id = c.sede_id
     WHERE r.usuario_id = :id
     ORDER BY r.fecha DESC'
);
$stmt->execute([':id' => $_SESSION['usuario_id']]);
$reservas = $stmt->fetchAll();

$titulo_pagina = 'Mi panel - Forja Gym';
$pagina_activa = 'panel';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">Mi panel</span>
        <h1>HOLA,<br><?php echo e(mb_strtoupper($_SESSION['usuario_nombre'])); ?>.</h1>
        <p class="lead">Rol: <strong><?php echo e($_SESSION['rol']); ?></strong></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (($_GET['error'] ?? '') === 'sin_permiso'): ?>
            <div class="notice notice-error" role="alert">No tenés permisos para acceder a esa sección.</div>
        <?php endif; ?>
        <h2>Mis reservas</h2>
        <?php if (!$reservas): ?>
            <p class="muted">Todavía no tenés reservas.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead><tr><th>Clase</th><th>Día</th><th>Hora</th><th>Sede</th><th>Fecha</th><th>Estado</th></tr></thead>
                    <tbody>
                    <?php foreach ($reservas as $r): ?>
                        <tr>
                            <td><?php echo e($r['clase']); ?></td>
                            <td><?php echo e($r['dia_semana']); ?></td>
                            <td><?php echo e(substr($r['hora'], 0, 5)); ?></td>
                            <td><?php echo e($r['sede']); ?></td>
                            <td><?php echo e($r['fecha']); ?></td>
                            <td><?php echo e($r['estado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
