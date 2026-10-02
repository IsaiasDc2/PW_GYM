<?php
require_once __DIR__ . '/../config/env.php';
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
    <title><?php echo htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a class="skip-link" href="#contenido">Saltar al contenido principal</a>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="index.php">FORJA<span class="brand-dot">.</span></a>
            <?php require __DIR__ . '/nav.php'; ?>
            <a class="btn btn-primary" href="contacto.php">Empezá hoy</a>
            <button type="button" class="hamburger" aria-label="Abrir menú" aria-expanded="false">☰</button>
        </div>
        <nav class="mobile-menu" aria-label="Menú móvil">
            <a href="index.php"<?php echo ($pagina_activa === 'inicio') ? ' class="active" aria-current="page"' : ''; ?>>Inicio</a>
            <a href="clases.php"<?php echo ($pagina_activa === 'clases') ? ' class="active" aria-current="page"' : ''; ?>>Clases</a>
            <a href="contacto.php"<?php echo ($pagina_activa === 'contacto') ? ' class="active" aria-current="page"' : ''; ?>>Contacto</a>
            <a class="btn btn-primary" href="contacto.php">Empezá hoy</a>
        </nav>
    </header>
    <main id="contenido">
