<?php
require_once __DIR__ . '/../config/env.php';

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self'; form-action 'self'; frame-ancestors 'none'; base-uri 'self'");
}

const SESION_INACTIVIDAD = 1800;

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']),
    ]);
    session_start();

    if (isset($_SESSION['usuario_id'])) {
        if (time() - ($_SESSION['ultima_actividad'] ?? 0) > SESION_INACTIVIDAD) {
            $_SESSION = [];
            session_destroy();
            session_start();
        } else {
            $_SESSION['ultima_actividad'] = time();
        }
    }
}

function e($valor): string
{
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES, 'UTF-8');
}

function post(string $clave): string
{
    $valor = $_POST[$clave] ?? '';
    return is_string($valor) ? trim($valor) : '';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_campo(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valido(): bool
{
    return isset($_SESSION['csrf'], $_POST['csrf']) && is_string($_POST['csrf'])
        && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

function redirigir(string $url): void
{
    header('Location: ' . $url);
    exit;
}
