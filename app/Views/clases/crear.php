<?php
$titulo_pagina = $titulo_pagina ?? 'Nueva clase - Forja Gym';
$pagina_activa = $pagina_activa ?? 'panel';
require_once __DIR__ . '/../../../includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1 class="h2 mb-4">Nueva clase</h1>
        <?php require __DIR__ . '/form.php'; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
