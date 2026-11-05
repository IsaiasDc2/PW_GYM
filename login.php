<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/conexion.php';

if (isset($_SESSION['usuario_id'])) {
    redirigir(($_SESSION['rol'] ?? '') === 'admin' ? 'admin_panel.php' : 'dashboard.php');
}

$error = '';
$ip = substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 45);
$email = '';

function bloqueado_por_intentos(PDO $pdo, string $email, string $ip): bool
{
    $pdo->exec('DELETE FROM login_intentos WHERE created_at < (NOW() - INTERVAL 1 DAY)');
    $stmt = $pdo->prepare(
        'SELECT COALESCE(SUM(email = :email), 0) AS por_email, COALESCE(SUM(ip = :ip), 0) AS por_ip
         FROM login_intentos WHERE created_at > (NOW() - INTERVAL 15 MINUTE)'
    );
    $stmt->execute([':email' => $email, ':ip' => $ip]);
    $r = $stmt->fetch();
    return (int) $r['por_email'] >= 5 || (int) $r['por_ip'] >= 30;
}
$aviso = '';

if (($_GET['error'] ?? '') === 'acceso_denegado') {
    $error = 'Tenés que iniciar sesión para acceder a esa página.';
}
if (($_GET['registro'] ?? '') === 'ok') {
    $aviso = 'Cuenta creada correctamente. Ya podés ingresar.';
}
if (($_GET['msg'] ?? '') === 'logout') {
    $aviso = 'Cerraste sesión correctamente.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mb_strtolower(post('email'));
    $password = $_POST['password'] ?? '';
    $password = is_string($password) ? $password : '';

    if (!csrf_valido()) {
        $error = 'La sesión del formulario expiró. Volvé a intentarlo.';
    } elseif ($email === '' || $password === '') {
        $error = 'Completá el email y la contraseña.';
    } elseif (bloqueado_por_intentos($pdo, $email, $ip)) {
        $error = 'Demasiados intentos fallidos. Esperá 15 minutos e intentá de nuevo.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT u.id, u.nombre, u.password, r.nombre AS rol
             FROM usuarios u
             INNER JOIN roles r ON r.id = u.rol_id
             WHERE u.email = :email'
        );
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        $hash = $usuario['password'] ?? '$2y$10$usesomesillystringforsaltedhashfakeAAAAAAAAAAAAAAAAAAAAAAAA';
        if (password_verify($password, $hash) && $usuario) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = (int) $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['ultima_actividad'] = time();
            $pdo->prepare('DELETE FROM login_intentos WHERE email = :email')->execute([':email' => $email]);
            redirigir($usuario['rol'] === 'admin' ? 'admin_panel.php' : 'dashboard.php');
        }
        $pdo->prepare('INSERT INTO login_intentos (email, ip) VALUES (:email, :ip)')
            ->execute([':email' => mb_substr($email, 0, 120), ':ip' => $ip]);
        $error = 'Email o contraseña incorrectos.';
    }
}

$titulo_pagina = 'Ingresar - Forja Gym';
$pagina_activa = 'login';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="container">
        <span class="kicker">Acceso</span>
        <h1>INGRESÁ<br>A TU CUENTA.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($error): ?>
            <div class="notice notice-error" role="alert"><?php echo e($error); ?></div>
        <?php endif; ?>
        <?php if ($aviso): ?>
            <div class="notice notice-success" role="status"><?php echo e($aviso); ?></div>
        <?php endif; ?>
        <form class="form card" method="post" action="login.php" novalidate>
            <?php echo csrf_campo(); ?>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" maxlength="120" autocomplete="email" value="<?php echo e($email); ?>" required>
            </div>
            <div class="field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ingresar</button>
                <a class="btn btn-ghost" href="registro.php">Crear cuenta</a>
            </div>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
