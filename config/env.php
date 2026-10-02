<?php
$ruta = dirname(__DIR__) . '/.env';
if (is_readable($ruta)) {
    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if ($linea === '' || $linea[0] === '#') {
            continue;
        }
        $partes = explode('=', $linea, 2);
        if (count($partes) === 2) {
            $clave = trim($partes[0]);
            $valor = trim($partes[1]);
            $_ENV[$clave] = $valor;
            putenv($clave . '=' . $valor);
        }
    }
}
if (!defined('APP_ENV')) {
    define('APP_ENV', $_ENV['APP_ENV'] ?? 'local');
}
if (!defined('SITIO_NOMBRE')) {
    define('SITIO_NOMBRE', $_ENV['SITIO_NOMBRE'] ?? 'Forja Gym');
}
if (!defined('SOPORTE_EMAIL')) {
    define('SOPORTE_EMAIL', $_ENV['SOPORTE_EMAIL'] ?? 'contacto@forjagym.com.ar');
}
