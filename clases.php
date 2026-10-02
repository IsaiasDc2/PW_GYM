<?php
$titulo_pagina = 'Clases - Forja Gym';
$pagina_activa = 'clases';
require_once 'includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">Clases y Horarios</span>
        <h1>ENCONTRÁ<br>TU CLASE.</h1>
        <p class="lead">Funcional, CrossFit, Spinning, Yoga, Boxing y Pilates, con instructores certificados.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="form-row">
            <div class="field">
                <label for="filtro">Filtrar por categoría</label>
                <select id="filtro" name="filtro">
                    <option value="">Todas</option>
                    <option value="Funcional">Funcional</option>
                    <option value="Spinning">Spinning</option>
                    <option value="CrossFit">CrossFit</option>
                    <option value="Yoga">Yoga</option>
                    <option value="Boxing">Boxing</option>
                    <option value="Pilates">Pilates</option>
                </select>
            </div>
        </div>
        <div class="cards-grid">
            <article class="card"><h3>Funcional AM</h3><p><strong>Categoría:</strong> Funcional</p><p><strong>Horario:</strong> Lunes 09:00</p><p class="muted">Instructor: Lucía Gómez</p></article>
            <article class="card"><h3>Funcional PM</h3><p><strong>Categoría:</strong> Funcional</p><p><strong>Horario:</strong> Martes 18:00</p><p class="muted">Instructor: Marco Ruiz</p></article>
            <article class="card"><h3>WOD CrossFit</h3><p><strong>Categoría:</strong> CrossFit</p><p><strong>Horario:</strong> Miércoles 19:00</p><p class="muted">Instructor: Diego Torres</p></article>
            <article class="card"><h3>Spinning Night</h3><p><strong>Categoría:</strong> Spinning</p><p><strong>Horario:</strong> Jueves 18:30</p><p class="muted">Instructor: Carla Méndez</p></article>
            <article class="card"><h3>Yoga Flow</h3><p><strong>Categoría:</strong> Yoga</p><p><strong>Horario:</strong> Viernes 08:00</p><p class="muted">Instructor: Ana Sosa</p></article>
            <article class="card"><h3>Boxing Fit</h3><p><strong>Categoría:</strong> Boxing</p><p><strong>Horario:</strong> Lunes 20:00</p><p class="muted">Instructor: Pablo Ríos</p></article>
            <article class="card"><h3>Pilates Core</h3><p><strong>Categoría:</strong> Pilates</p><p><strong>Horario:</strong> Miércoles 10:00</p><p class="muted">Instructor: Sofía Díaz</p></article>
            <article class="card"><h3>HIIT Express</h3><p><strong>Categoría:</strong> Funcional</p><p><strong>Horario:</strong> Sábado 10:00</p><p class="muted">Instructor: Marco Ruiz</p></article>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <span class="kicker">Nuestras Sedes</span>
        <h2>ENCONTRÁ TU FORJA.</h2>
        <div class="plans">
            <article class="card"><h3>Forja Centro</h3><p class="muted">Lunes a Viernes: 06:00 - 23:00</p><p class="muted">Sábados: 08:00 - 20:00</p></article>
            <article class="card"><h3>Forja Norte</h3><p class="muted">Lunes a Viernes: 06:00 - 23:00</p><p class="muted">Sábados: 08:00 - 20:00</p></article>
            <article class="card"><h3>Forja Sur</h3><p class="muted">Lunes a Viernes: 06:00 - 23:00</p><p class="muted">Sábados: 08:00 - 20:00</p></article>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
