<?php
require_once __DIR__ . '/includes/functions.php';
$clases = require __DIR__ . '/includes/data.php';

$valores_post = ['nombre' => '', 'apellido' => '', 'email' => '', 'telefono' => '', 'sede' => '', 'mensaje' => ''];
$errores_post = [];
$exito_post = null;
$hubo_envio_post = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($hubo_envio_post) {
    $entrada = [
        'nombre'   => post('nombre'),
        'apellido' => post('apellido'),
        'email'    => post('email'),
        'telefono' => post('telefono'),
        'sede'     => post('sede'),
        'mensaje'  => post('mensaje'),
    ];
    $resultado = validar_contacto($entrada);
    $errores_post = $resultado['errores'];
    $valores_post = $resultado['datos'];

    if (empty($errores_post)) {
        $exito_post = '¡Gracias, ' . $valores_post['nombre'] . '! Recibimos tu mensaje y te contactaremos a ' . $valores_post['email'] . ' (sede ' . $valores_post['sede'] . ').';
        $valores_post = ['nombre' => '', 'apellido' => '', 'email' => '', 'telefono' => '', 'sede' => '', 'mensaje' => ''];
    }
}

$q = get_param('q');
$cat = get_param('cat');
if ($cat !== '' && !in_array($cat, categorias_validas(), true)) {
    $cat = '';
}
$hubo_busqueda = isset($_GET['q']) || isset($_GET['cat']);
$resultados = filtrar_clases($clases, $q, $cat);

$titulo_pagina = 'Forja Gym · Contacto y Clases (TP5)';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container">
        <span class="kicker">PW_GYM</span>
        <h1>FORJÁ<br>TU MEJOR<br>VERSIÓN</h1>
        <p class="lead">Contacto por <strong>POST</strong> y buscador de clases por <strong>GET</strong>, con sanitización estricta anti-XSS.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="#contacto">Ir al formulario POST</a>
        </div>
        <div class="stats" aria-hidden="true">
            <div><strong>2.400+</strong><span>Socios activos</span></div>
            <div><strong>3</strong><span>Sedes</span></div>
            <div><strong>15</strong><span>Años</span></div>
            <div><strong>40+</strong><span>Instructores</span></div>
        </div>
    </div>
</section>

<section id="nosotros" class="section">
    <div class="container grid-2">
        <div>
            <span class="kicker">Sobre Nosotros</span>
            <h2>NO SOMOS<br>UN GIMNASIO<br>MÁS.</h2>
            <p>Fundado en 2009, Forja rompe las barreras entre el fitness de élite y el acceso real. Resultados medibles, mes a mes.</p>
            <ul class="checklist">
                <li>Disciplina real</li>
                <li>Sin excusas</li>
                <li>Comunidad sólida</li>
                <li>Resultados comprobados</li>
            </ul>
        </div>
        <div class="card">
            <p><strong>98%</strong> tasa de retención.</p>
            <p class="muted">Cada instructor tiene certificación internacional. Cada plan se diseña según tu cuerpo, objetivo y tiempo.</p>
        </div>
    </div>
</section>

<section id="planes" class="section section-alt">
    <div class="container">
        <span class="kicker">Planes y Precios</span>
        <h2>ELEGÍ TU NIVEL.</h2>
        <p class="muted">Sin permanencia. Podés cambiar de plan cuando quieras.</p>
        <div class="plans">
            <article class="card"><h3>BÁSICO — $18.900/mes</h3><p class="muted">Sala de pesas, vestuarios premium, app, 1 clase/semana.</p></article>
            <article class="card featured"><h3>PRO — $29.900/mes</h3><p class="muted">Clases ilimitadas, 1 sesión PT/mes, nutrición, 3 sedes.</p></article>
            <article class="card"><h3>ELITE — $44.900/mes</h3><p class="muted">4 PT/mes, plan nutricional, wearables, prioridad.</p></article>
        </div>
    </div>
</section>

<section id="clases" class="section">
    <div class="container">
        <span class="kicker">Clases y Horarios · Formulario GET</span>
        <h2>ENCONTRÁ TU CLASE.</h2>
        <p class="muted">Este formulario usa <code>method="get"</code>: ideal para búsquedas y filtros (los parámetros viajan en la URL y se pueden compartir). Todo lo recibido por <code>$_GET</code> se sanitiza antes de mostrarse.</p>

        <form class="card form" method="get" action="index.php#clases" role="search">
            <div class="form-row">
                <div class="field">
                    <label for="q">Buscar (nombre, instructor, horario)</label>
                    <input type="text" id="q" name="q" maxlength="80" placeholder="Ej: yoga, lunes, Lucía…" value="<?php echo e($q); ?>">
                </div>
                <div class="field">
                    <label for="cat">Categoría</label>
                    <select id="cat" name="cat">
                        <option value="">Todas</option>
                        <?php foreach (categorias_validas() as $c): ?>
                            <option value="<?php echo e($c); ?>" <?php echo ($cat === $c) ? 'selected' : ''; ?>><?php echo e($c); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a class="btn btn-ghost" href="index.php#clases">Limpiar</a>
            </div>
        </form>

        <?php if ($hubo_busqueda): ?>
            <div class="notice notice-info" role="status">
                <?php if ($q !== '' || $cat !== ''): ?>
                    Resultados para
                    <?php if ($q !== ''): ?>“<strong><?php echo e($q); ?></strong>”<?php endif; ?>
                    <?php if ($cat !== ''): ?>en categoría <strong><?php echo e($cat); ?></strong><?php endif; ?>:
                    <strong><?php echo count($resultados); ?></strong> encontrada(s).
                    <span class="muted small">Probá XSS: <code>&lt;script&gt;alert(1)&lt;/script&gt;</code> — se muestra escapado, no se ejecuta.</span>
                <?php else: ?>
                    Mostrando las <strong><?php echo count($resultados); ?></strong> clases disponibles.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($resultados)): ?>
            <p class="notice notice-error" role="alert">Sin resultados. Probá con otra palabra o categoría.</p>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($resultados as $clase): ?>
                    <article class="card">
                        <h3><?php echo e($clase['nombre']); ?></h3>
                        <p><strong>Categoría:</strong> <?php echo e($clase['categoria']); ?></p>
                        <p><strong>Horario:</strong> <?php echo e($clase['horario']); ?></p>
                        <p class="muted">Instructor: <?php echo e($clase['instructor']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section id="contacto" class="section section-alt">
    <div class="container grid-2">
        <div>
            <span class="kicker">Contacto · Formulario </span>
            <h2>EMPEZÁ HOY.</h2>
            <p class="muted">Este formulario usa <code>method="post"</code>: los datos viajan en el cuerpo de la petición (adecuado para registro/contacto). Se valida en servidor con <code>isset()</code>, <code>empty()</code>, <code>filter_var()</code> y se escapa con <code>htmlspecialchars()</code> + <code>trim()</code>.</p>
            <ul class="checklist">
                <li>Campos requeridos validados en servidor</li>
                <li>Email con formato verificado</li>
                <li>Sede contra lista blanca</li>
                <li>Si hay errores, se conservan tus datos</li>
            </ul>
        </div>
        <div class="card">
            <?php if ($exito_post !== null): ?>
                <p class="notice notice-success" role="status"><?php echo e($exito_post); ?></p>
            <?php endif; ?>

            <?php if (!empty($errores_post)): ?>
                <div class="notice notice-error" role="alert">
                    <strong>Revisá el formulario (<?php echo count($errores_post); ?> error/es):</strong>
                    <ul>
                        <?php foreach ($errores_post as $msg): ?>
                            <li><?php echo e($msg); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="form" method="post" action="index.php#contacto" novalidate>
                <div class="form-row">
                    <div class="field">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" maxlength="50" required value="<?php echo e($valores_post['nombre']); ?>">
                        <?php if (isset($errores_post['nombre'])): ?><small class="field-error"><?php echo e($errores_post['nombre']); ?></small><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="apellido">Apellido *</label>
                        <input type="text" id="apellido" name="apellido" maxlength="50" required value="<?php echo e($valores_post['apellido']); ?>">
                        <?php if (isset($errores_post['apellido'])): ?><small class="field-error"><?php echo e($errores_post['apellido']); ?></small><?php endif; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" maxlength="120" required value="<?php echo e($valores_post['email']); ?>">
                        <?php if (isset($errores_post['email'])): ?><small class="field-error"><?php echo e($errores_post['email']); ?></small><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="telefono">Teléfono (opcional)</label>
                        <input type="tel" id="telefono" name="telefono" maxlength="20" placeholder="+54 11 1234 5678" value="<?php echo e($valores_post['telefono']); ?>">
                        <?php if (isset($errores_post['telefono'])): ?><small class="field-error"><?php echo e($errores_post['telefono']); ?></small><?php endif; ?>
                    </div>
                </div>
                <div class="field">
                    <label for="sede">Sede de interés *</label>
                    <select id="sede" name="sede" required>
                        <option value="">— Elegí una sede —</option>
                        <?php foreach (sedes_validas() as $s): ?>
                            <option value="<?php echo e($s); ?>" <?php echo ($valores_post['sede'] === $s) ? 'selected' : ''; ?>>Forja <?php echo e($s); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errores_post['sede'])): ?><small class="field-error"><?php echo e($errores_post['sede']); ?></small><?php endif; ?>
                </div>
                <div class="field">
                    <label for="mensaje">Mensaje *</label>
                    <textarea id="mensaje" name="mensaje" rows="4" maxlength="1000" required><?php echo e($valores_post['mensaje']); ?></textarea>
                    <?php if (isset($errores_post['mensaje'])): ?><small class="field-error"><?php echo e($errores_post['mensaje']); ?></small><?php endif; ?>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
