<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/conexion.php';

if (isset($_SESSION['usuario_id'])) {
    redirigir('dashboard.php');
}

$errores = [];
$nombre = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = post('nombre');
    $email = mb_strtolower(post('email'));
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!csrf_valido()) {
        $errores[] = 'La sesión del formulario expiró. Volvé a intentarlo.';
    }
    if ($nombre === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (!preg_match("/^[\p{L}][\p{L} '\-]{1,49}$/u", $nombre)) {
        $errores['nombre'] = 'Usá entre 2 y 50 letras, espacios, apóstrofes o guiones.';
    }
    if ($email === '') {
        $errores['email'] = 'El email es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
        $errores['email'] = 'El formato del email no es válido.';
    }
    if (!is_string($password) || strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $errores['password'] = 'La contraseña debe tener al menos 8 caracteres, con letras y números.';
    } elseif (strlen($password) > 72) {
        $errores['password'] = 'La contraseña no puede superar los 72 caracteres.';
    } elseif ($password !== $password2) {
        $errores['password2'] = 'Las contraseñas no coinciden.';
    }

    if (!$errores) {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $errores['email'] = 'Ya existe una cuenta con ese email.';
        }
    }

    if (!$errores) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO usuarios (nombre, email, password, rol_id)
                 VALUES (:nombre, :email, :password, (SELECT id FROM roles WHERE nombre = 'usuario'))"
            );
            $stmt->execute([':nombre' => $nombre, ':email' => $email, ':password' => $hash]);
            redirigir('login.php?registro=ok');
        } catch (PDOException $ex) {
            $errores['email'] = $ex->getCode() === '23000'
                ? 'Ya existe una cuenta con ese email.'
                : 'No se pudo completar el registro. Intentá más tarde.';
        }
    }
}

$titulo_pagina = 'Registro - Forja Gym';
$pagina_activa = 'registro';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">Registro</span>
        <h1>CREÁ<br>TU CUENTA.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($errores): ?>
            <div class="notice notice-error" role="alert">
                <strong>Revisá los datos (<?php echo count($errores); ?>):</strong>
                <ul>
                    <?php foreach ($errores as $msg): ?>
                        <li><?php echo e($msg); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form class="form card" method="post" action="registro.php" novalidate>
            <?php echo csrf_campo(); ?>
            <div class="field">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" maxlength="50" autocomplete="name" value="<?php echo e($nombre); ?>" required>
                <?php if (isset($errores['nombre'])): ?><span class="field-error"><?php echo e($errores['nombre']); ?></span><?php endif; ?>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" maxlength="120" autocomplete="email" value="<?php echo e($email); ?>" required>
                <?php if (isset($errores['email'])): ?><span class="field-error"><?php echo e($errores['email']); ?></span><?php endif; ?>
            </div>
            <div class="field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" autocomplete="new-password" required>
                <?php if (isset($errores['password'])): ?><span class="field-error"><?php echo e($errores['password']); ?></span><?php endif; ?>
            </div>
            <div class="field">
                <label for="password2">Repetir contraseña</label>
                <input type="password" id="password2" name="password2" autocomplete="new-password" required>
                <?php if (isset($errores['password2'])): ?><span class="field-error"><?php echo e($errores['password2']); ?></span><?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Registrarme</button>
                <a class="btn btn-ghost" href="login.php">Ya tengo cuenta</a>
            </div>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
