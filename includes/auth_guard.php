<?php
require_once __DIR__ . '/auth.php';

$base = $base ?? '';

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

if (!isset($_SESSION['usuario_id'])) {
    redirigir($base . 'login.php?error=acceso_denegado');
}

require_once __DIR__ . '/../config/conexion.php';
$stmt = $pdo->prepare(
    'SELECT r.nombre AS rol FROM usuarios u INNER JOIN roles r ON r.id = u.rol_id WHERE u.id = :id'
);
$stmt->execute([':id' => $_SESSION['usuario_id']]);
$actual = $stmt->fetch();

if (!$actual) {
    $_SESSION = [];
    session_destroy();
    redirigir($base . 'login.php?error=acceso_denegado');
}
$_SESSION['rol'] = $actual['rol'];

if (isset($rol_requerido) && $actual['rol'] !== $rol_requerido) {
    redirigir($base . 'dashboard.php?error=sin_permiso');
}
