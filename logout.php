<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valido()) {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $p['path'],
            'domain' => $p['domain'],
            'secure' => $p['secure'],
            'httponly' => $p['httponly'],
            'samesite' => $p['samesite'] ?: 'Lax',
        ]);
    }

    session_destroy();
    redirigir('login.php?msg=logout');
}

if (!isset($_SESSION['usuario_id'])) {
    redirigir('login.php');
}

$titulo_pagina = 'Cerrar sesión - Forja Gym';
$pagina_activa = 'salir';
require_once __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container">
        <form class="form card" method="post" action="logout.php">
            <?php echo csrf_campo(); ?>
            <h1 class="h3">¿Querés cerrar la sesión?</h1>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                <a class="btn btn-ghost" href="dashboard.php">Cancelar</a>
            </div>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
