<?php
$base = $base ?? '';
$pagina_activa = $pagina_activa ?? 'inicio';
$items = [
    'inicio' => ['url' => 'index.php', 'texto' => 'Inicio'],
    'clases' => ['url' => 'clases.php', 'texto' => 'Clases'],
    'contacto' => ['url' => 'contacto.php', 'texto' => 'Contacto'],
];
if (isset($_SESSION['usuario_id'])) {
    $es_admin = ($_SESSION['rol'] ?? '') === 'admin';
    $items['panel'] = ['url' => $es_admin ? 'admin_panel.php' : 'dashboard.php', 'texto' => 'Mi panel'];
    $items['salir'] = ['url' => 'logout.php', 'texto' => 'Salir (' . ($_SESSION['usuario_nombre'] ?? '') . ')'];
} else {
    $items['login'] = ['url' => 'login.php', 'texto' => 'Ingresar'];
    $items['registro'] = ['url' => 'registro.php', 'texto' => 'Registrarse'];
}
?>
<nav class="main-nav" aria-label="Navegación principal">
    <?php foreach ($items as $clave => $item): ?>
        <a href="<?php echo e($base . $item['url']); ?>"<?php echo ($pagina_activa === $clave) ? ' class="active" aria-current="page"' : ''; ?>><?php echo e($item['texto']); ?></a>
    <?php endforeach; ?>
</nav>
