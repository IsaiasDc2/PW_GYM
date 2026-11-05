<?php
$base = '../';
$rol_requerido = 'admin';
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../includes/clases_funciones.php';

$catalogos = cargar_catalogos($pdo);
$datos = ['nombre' => '', 'categoria_id' => '', 'instructor_id' => '', 'sede_id' => '', 'dia_semana' => '', 'hora' => '', 'cupo' => '20'];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = datos_clase_desde_post();
    $errores = validar_clase($datos, $catalogos);
    if (!csrf_valido()) {
        $errores['csrf'] = 'La sesión del formulario expiró.';
    }
    if (!$errores) {
        $sql = 'INSERT INTO clases (nombre, categoria_id, instructor_id, sede_id, dia_semana, hora, cupo)
                VALUES (:nombre, :categoria_id, :instructor_id, :sede_id, :dia_semana, :hora, :cupo)';
        $pdo->prepare($sql)->execute(parametros_clase($datos));
        redirigir('index.php?status=created');
    }
}

$titulo_pagina = 'Nueva clase - Forja Gym';
$pagina_activa = 'panel';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1 class="h2 mb-4">Nueva clase</h1>
        <?php require __DIR__ . '/_form.php'; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
