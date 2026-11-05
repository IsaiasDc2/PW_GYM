<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

require_once __DIR__ . '/../config/env.php';

function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    header('Allow: GET');
    responder(405, [
        'status' => 'error',
        'message' => 'Método no permitido. La API solo acepta GET.',
    ]);
}

$busqueda = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
$categoria = isset($_GET['categoria']) && is_string($_GET['categoria']) ? trim($_GET['categoria']) : '';

if (mb_strlen($busqueda) > 60) {
    responder(400, [
        'status' => 'error',
        'message' => 'La búsqueda no puede superar los 60 caracteres.',
    ]);
}

if (mb_strlen($categoria) > 40) {
    responder(400, [
        'status' => 'error',
        'message' => 'La categoría no puede superar los 40 caracteres.',
    ]);
}

try {
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log('API clases - Error de conexión: ' . $e->getMessage());
    responder(500, [
        'status' => 'error',
        'message' => 'No se pudo conectar con la base de datos.',
    ]);
}

try {
    if ($categoria !== '') {
        $stmtCategoria = $pdo->prepare('SELECT id FROM categorias_clase WHERE nombre = :nombre LIMIT 1');
        $stmtCategoria->execute([':nombre' => $categoria]);
        if ($stmtCategoria->fetchColumn() === false) {
            responder(400, [
                'status' => 'error',
                'message' => 'La categoría indicada no existe.',
            ]);
        }
    }

    $sql = "SELECT c.id, c.nombre, cat.nombre AS categoria,
                   CONCAT(u.nombre, ' ', u.apellido) AS instructor,
                   s.nombre AS sede, c.dia_semana, c.hora, c.cupo
            FROM clases c
            INNER JOIN categorias_clase cat ON cat.id = c.categoria_id
            INNER JOIN usuarios u ON u.id = c.instructor_id
            INNER JOIN sedes s ON s.id = c.sede_id
            WHERE 1 = 1";
    $parametros = [];

    if ($busqueda !== '') {
        $sql .= " AND (c.nombre LIKE :busqueda_nombre
                    OR CONCAT(u.nombre, ' ', u.apellido) LIKE :busqueda_instructor
                    OR cat.nombre LIKE :busqueda_categoria
                    OR s.nombre LIKE :busqueda_sede)";
        $valorBusqueda = '%' . addcslashes($busqueda, '\\%_') . '%';
        $parametros[':busqueda_nombre'] = $valorBusqueda;
        $parametros[':busqueda_instructor'] = $valorBusqueda;
        $parametros[':busqueda_categoria'] = $valorBusqueda;
        $parametros[':busqueda_sede'] = $valorBusqueda;
    }

    if ($categoria !== '') {
        $sql .= ' AND cat.nombre = :categoria';
        $parametros[':categoria'] = $categoria;
    }

    $sql .= " ORDER BY FIELD(c.dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
                     c.hora ASC, c.nombre ASC
              LIMIT 50";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametros);
    $clases = $stmt->fetchAll();

    $datos = array_map(static function (array $clase): array {
        return [
            'id' => (int) $clase['id'],
            'nombre' => $clase['nombre'],
            'categoria' => $clase['categoria'],
            'instructor' => $clase['instructor'],
            'sede' => $clase['sede'],
            'dia_semana' => $clase['dia_semana'],
            'hora' => substr((string) $clase['hora'], 0, 5),
            'cupo' => (int) $clase['cupo'],
        ];
    }, $clases);

    responder(200, [
        'status' => 'success',
        'total' => count($datos),
        'query' => $busqueda,
        'categoria' => $categoria,
        'data' => $datos,
    ]);
} catch (PDOException $e) {
    error_log('API clases - Error de consulta: ' . $e->getMessage());
    responder(500, [
        'status' => 'error',
        'message' => 'Error al consultar la base de datos.',
    ]);
}
