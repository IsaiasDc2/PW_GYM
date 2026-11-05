<?php
$titulo_pagina = $titulo_pagina ?? 'Editar clase - Forja Gym';
$pagina_activa = $pagina_activa ?? 'panel';
require_once __DIR__ . '/../../../includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1 class="h2 mb-4">Editar clase #<?php echo e($id); ?></h1>
        <?php require __DIR__ . '/form.php'; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
