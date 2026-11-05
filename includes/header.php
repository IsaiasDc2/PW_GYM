<?php
require_once __DIR__ . '/auth.php';
$base = $base ?? '';
if (!isset($titulo_pagina)) {
    $titulo_pagina = SITIO_NOMBRE;
}
if (!isset($pagina_activa)) {
    $pagina_activa = 'inicio';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Forja Gym: entrenamiento de fuerza, clases grupales, nutrición y comunidad.">
    <title><?php echo e($titulo_pagina); ?></title>
    <link href="<?php echo e($base); ?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e($base); ?>css/style.css">
</head>
<body>
    <a class="skip-link" href="#contenido">Saltar al contenido principal</a>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="<?php echo e($base); ?>index.php">FORJA<span class="brand-dot">.</span></a>
            <?php require __DIR__ . '/nav.php'; ?>
            <a class="btn btn-primary" href="<?php echo e($base); ?>contacto.php">Empezá hoy</a>
            <button type="button" class="hamburger" aria-label="Abrir menú" aria-expanded="false">☰</button>
        </div>
        <nav class="mobile-menu" aria-label="Menú móvil">
            <?php foreach ($items as $clave => $item): ?>
                <a href="<?php echo e($base . $item['url']); ?>"<?php echo ($pagina_activa === $clave) ? ' class="active" aria-current="page"' : ''; ?>><?php echo e($item['texto']); ?></a>
            <?php endforeach; ?>
            <a class="btn btn-primary" href="<?php echo e($base); ?>contacto.php">Empezá hoy</a>
        </nav>
    </header>
    <main id="contenido">
