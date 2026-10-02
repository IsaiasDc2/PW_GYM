<?php
if (!isset($titulo_pagina)) {
    $titulo_pagina = 'Forja Gym';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Forja Gym: entrenamiento de fuerza, clases grupales, nutrición y comunidad. Contacto y buscador de clases con procesamiento seguro en PHP.">
    <title><?php echo htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a class="skip-link" href="#contenido">Saltar al contenido principal</a>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="index.php">FORJA<span class="brand-dot">.</span></a>
            <nav class="main-nav" aria-label="Navegación principal">
                <a href="index.php#nosotros">Nosotros</a>
                <a href="index.php#planes">Planes</a>
                <a href="index.php#clases">Clases</a>
                <a href="index.php#contacto">Contacto</a>
            </nav>
            <a class="btn btn-primary" href="index.php#contacto">Empezá hoy</a>
            <button type="button" class="hamburger" aria-label="Abrir menú" aria-expanded="false">☰</button>
        </div>
        <nav class="mobile-menu" aria-label="Menú móvil">
            <a href="index.php#nosotros">Nosotros</a>
            <a href="index.php#planes">Planes</a>
            <a href="index.php#clases">Clases</a>
            <a href="index.php#contacto">Contacto</a>
            <a class="btn btn-primary" href="index.php#contacto">Empezá hoy</a>
        </nav>
    </header>
    <main id="contenido">
