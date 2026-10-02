<?php
$titulo_pagina = 'Inicio - Forja Gym';
$pagina_activa = 'inicio';
require_once 'includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">El gimnasio que te transforma</span>
        <h1>FORJÁ<br>TU MEJOR<br>VERSIÓN</h1>
        <p class="lead">Más de 15 años construyendo atletas. Entrenamiento de élite, nutrición personalizada y tecnología al servicio de tu progreso.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="contacto.php">Empezá hoy</a>
        </div>
        <div class="stats row g-3">
            <div class="col-6 col-md-3"><strong>2.400+</strong><span>Socios activos</span></div>
            <div class="col-6 col-md-3"><strong>3</strong><span>Sedes</span></div>
            <div class="col-6 col-md-3"><strong>15</strong><span>Años de experiencia</span></div>
            <div class="col-6 col-md-3"><strong>40+</strong><span>Instructores</span></div>
        </div>
    </div>
</section>

<section id="nosotros" class="section">
    <div class="container">
    <div class="row g-4 align-items-start">
        <div class="col-lg-6">
            <span class="kicker">Sobre Nosotros</span>
            <h2>NO SOMOS<br>UN GIMNASIO<br>MÁS.</h2>
            <p>Fundado en 2009, <?= SITIO_NOMBRE ?> nació con una misión clara: romper las barreras entre el fitness de élite y el acceso real.</p>
            <p>No prometemos milagros — entregamos resultados medibles, mes a mes.</p>
            <ul class="checklist">
                <li>Disciplina real</li>
                <li>Sin excusas</li>
                <li>Comunidad sólida</li>
                <li>Resultados comprobados</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <div class="card">
            <p><strong>98%</strong> tasa de retención.</p>
            <p class="muted">Cada instructor tiene certificación internacional. Cada plan se diseña en función de tu cuerpo, tu objetivo y tu tiempo.</p>
            </div>
        </div>
    </div>
    </div>
</section>

<section id="planes" class="section section-alt">
    <div class="container">
        <span class="kicker">Planes y Precios</span>
        <h2>ELEGÍ TU NIVEL.</h2>
        <p class="muted">Sin contratos de permanencia. Podés cambiar de plan en cualquier momento.</p>
        <div class="plans row g-3">
            <div class="col-md-4"><article class="card h-100"><h3>BÁSICO — $18.900/mes</h3><p class="muted">Sala de pesas, vestuarios premium, app, 1 clase/semana.</p></article></div>
            <div class="col-md-4"><article class="card featured h-100"><h3>PRO — $29.900/mes</h3><p class="muted">Clases ilimitadas, 1 sesión PT/mes, nutrición, 3 sedes.</p></article></div>
            <div class="col-md-4"><article class="card h-100"><h3>ELITE — $44.900/mes</h3><p class="muted">4 PT/mes, plan nutricional, wearables, prioridad.</p></article></div>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
