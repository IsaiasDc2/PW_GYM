<?php
$base = '../';
$rol_requerido = 'admin';
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../includes/clases_funciones.php';

$id = filter_var($_GET['id'] ?? $_POST['id'] ?? '', FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    redirigir('index.php?status=error');
}

$stmt = $pdo->prepare('SELECT * FROM clases WHERE id = :id');
$stmt->execute([':id' => $id]);
$clase = $stmt->fetch();
if (!$clase) {
    redirigir('index.php?status=error');
}

$catalogos = cargar_catalogos($pdo);
$datos = [
    'nombre' => $clase['nombre'],
    'categoria_id' => (string) $clase['categoria_id'],
    'instructor_id' => (string) $clase['instructor_id'],
    'sede_id' => (string) $clase['sede_id'],
    'dia_semana' => $clase['dia_semana'],
    'hora' => substr($clase['hora'], 0, 5),
    'cupo' => (string) $clase['cupo'],
];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = datos_clase_desde_post();
    $errores = validar_clase($datos, $catalogos);
    if (!csrf_valido()) {
        $errores['csrf'] = 'La sesión del formulario expiró.';
    }
    if (!$errores) {
        $sql = 'UPDATE clases SET nombre = :nombre, categoria_id = :categoria_id, instructor_id = :instructor_id,
                sede_id = :sede_id, dia_semana = :dia_semana, hora = :hora, cupo = :cupo WHERE id = :id';
        $pdo->prepare($sql)->execute(parametros_clase($datos) + [':id' => $id]);
        redirigir('index.php?status=updated');
    }
}

$titulo_pagina = 'Editar clase - Forja Gym';
$pagina_activa = 'panel';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1 class="h2 mb-4">Editar clase #<?php echo e($id); ?></h1>
        <?php require __DIR__ . '/_form.php'; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
