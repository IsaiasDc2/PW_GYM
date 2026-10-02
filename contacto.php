<?php
$titulo_pagina = 'Contacto - Forja Gym';
$pagina_activa = 'contacto';
require_once 'includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">Contacto</span>
        <h1>EMPEZÁ<br>HOY.</h1>
        <p class="lead">Estamos listos para ayudarte a alcanzar tus objetivos.</p>
    </div>
</section>

<section class="section">
    <div class="container grid-2">
        <div class="card">
            <h3>Escribinos</h3>
            <p class="muted">Email de soporte:</p>
            <p><a class="btn btn-ghost" href="mailto:<?php echo htmlspecialchars(SOPORTE_EMAIL, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(SOPORTE_EMAIL, ENT_QUOTES, 'UTF-8'); ?></a></p>
            <p class="muted">Formulario con validación y persistencia del lado del servidor:</p>
            <p><a class="btn btn-primary" href="clase5/index.php#contacto">Ir al formulario POST</a></p>
        </div>
        <div class="card">
            <h3>Sedes</h3>
            <p><strong>Forja Centro</strong><br><span class="muted">Lunes a Viernes: 06:00 - 23:00 · Sábados: 08:00 - 20:00</span></p>
            <p><strong>Forja Norte</strong><br><span class="muted">Lunes a Viernes: 06:00 - 23:00 · Sábados: 08:00 - 20:00</span></p>
            <p><strong>Forja Sur</strong><br><span class="muted">Lunes a Viernes: 06:00 - 23:00 · Sábados: 08:00 - 20:00</span></p>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
