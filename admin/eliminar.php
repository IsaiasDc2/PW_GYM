<?php
$base = '../';
$rol_requerido = 'admin';
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valido()) {
    redirigir('index.php?status=error');
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    redirigir('index.php?status=error');
}

$stmt = $pdo->prepare('DELETE FROM clases WHERE id = :id');
$stmt->execute([':id' => $id]);
redirigir('index.php?status=' . ($stmt->rowCount() > 0 ? 'deleted' : 'error'));
