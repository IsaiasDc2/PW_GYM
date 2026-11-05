<?php
const DIAS_SEMANA = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

function cargar_catalogos(PDO $pdo): array
{
    return [
        'categorias' => $pdo->query('SELECT id, nombre FROM categorias_clase ORDER BY nombre')->fetchAll(),
        'sedes' => $pdo->query('SELECT id, nombre FROM sedes ORDER BY nombre')->fetchAll(),
        'instructores' => $pdo->query(
            "SELECT u.id, CONCAT(u.nombre, ' ', u.apellido) AS nombre
             FROM usuarios u INNER JOIN roles r ON r.id = u.rol_id
             WHERE r.nombre = 'instructor' ORDER BY u.nombre"
        )->fetchAll(),
    ];
}

function datos_clase_desde_post(): array
{
    return [
        'nombre' => post('nombre'),
        'categoria_id' => post('categoria_id'),
        'instructor_id' => post('instructor_id'),
        'sede_id' => post('sede_id'),
        'dia_semana' => post('dia_semana'),
        'hora' => post('hora'),
        'cupo' => post('cupo'),
    ];
}

function validar_clase(array $d, array $cat): array
{
    $err = [];
    $len = mb_strlen($d['nombre']);
    if ($len < 3 || $len > 60) {
        $err['nombre'] = 'El nombre debe tener entre 3 y 60 caracteres.';
    }
    foreach (['categoria_id' => 'categorias', 'instructor_id' => 'instructores', 'sede_id' => 'sedes'] as $campo => $lista) {
        if (!in_array($d[$campo], array_map(fn($f) => (string) $f['id'], $cat[$lista]), true)) {
            $err[$campo] = 'Seleccioná una opción válida.';
        }
    }
    if (!in_array($d['dia_semana'], DIAS_SEMANA, true)) {
        $err['dia_semana'] = 'Seleccioná un día válido.';
    }
    if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $d['hora'])) {
        $err['hora'] = 'Ingresá una hora válida (HH:MM).';
    }
    if (filter_var($d['cupo'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 200]]) === false) {
        $err['cupo'] = 'El cupo debe ser un número entre 1 y 200.';
    }
    return $err;
}

function parametros_clase(array $d): array
{
    return [
        ':nombre' => $d['nombre'],
        ':categoria_id' => (int) $d['categoria_id'],
        ':instructor_id' => (int) $d['instructor_id'],
        ':sede_id' => (int) $d['sede_id'],
        ':dia_semana' => $d['dia_semana'],
        ':hora' => $d['hora'] . ':00',
        ':cupo' => (int) $d['cupo'],
    ];
}
