<?php
$base = '../';
$rol_requerido = 'admin';
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../app/autoload.php';

$controlador = new \App\Controllers\ClaseController($pdo);
