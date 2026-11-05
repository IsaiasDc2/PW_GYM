<?php
$rol_requerido = 'admin';
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/config/conexion.php';

$totales = [];
foreach (['usuarios', 'clases', 'reservas', 'suscripciones', 'consultas'] as $tabla) {
    $totales[$tabla] = (int) $pdo->query('SELECT COUNT(*) FROM ' . $tabla)->fetchColumn();
}

$titulo_pagina = 'Panel de administración - Forja Gym';
$pagina_activa = 'panel';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">Administración</span>
        <h1>PANEL<br>ADMIN.</h1>
        <p class="lead">Sesión de <strong><?php echo e($_SESSION['usuario_nombre']); ?></strong> (rol <?php echo e($_SESSION['rol']); ?>).</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats row g-3">
            <?php foreach ($totales as $nombre => $cantidad): ?>
                <div class="col-6 col-md"><strong><?php echo e($cantidad); ?></strong><span><?php echo e(ucfirst($nombre)); ?></span></div>
            <?php endforeach; ?>
        </div>
        <p class="mt-4"><a class="btn btn-primary" href="admin/index.php">Gestionar clases (CRUD)</a></p>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
