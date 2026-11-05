<?php
require_once __DIR__ . '/env.php';

$dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log('Error de conexión: ' . $e->getMessage());
    http_response_code(500);
    $detalle = APP_ENV === 'local' ? ': ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') : '';
    die('Error crítico de conexión con la base de datos' . $detalle);
}
