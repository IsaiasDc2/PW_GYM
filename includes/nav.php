<?php
if (!isset($pagina_activa)) {
    $pagina_activa = 'inicio';
}
$items = [
    'inicio' => ['url' => 'index.php', 'texto' => 'Inicio'],
    'clases' => ['url' => 'clases.php', 'texto' => 'Clases'],
    'contacto' => ['url' => 'contacto.php', 'texto' => 'Contacto'],
];
?>
<nav class="main-nav" aria-label="Navegación principal">
    <?php foreach ($items as $clave => $item): ?>
        <a href="<?php echo $item['url']; ?>"<?php echo ($pagina_activa === $clave) ? ' class="active" aria-current="page"' : ''; ?>><?php echo $item['texto']; ?></a>
    <?php endforeach; ?>
</nav>
