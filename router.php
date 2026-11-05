<?php
// Router para el servidor embebido: php -S localhost:8000 router.php
// El servidor embebido sirve cualquier archivo estático, incluidos .env y .sql.
$ruta = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

$bloqueado = '#(^|/)\.(?!well-known)|\.(sql|md|env|log|ini|bak|sqlite)$|^/(config|includes|tools|app)(/|$)|^/tp10-laravel(?:/(?!public(?:/|$))|$)|^/Trabajo Practico [0-9]+/(?!capturas|figma|bocetos|mapa_del_sitio)(/|$)#i';

if (preg_match($bloqueado, $ruta)) {
    http_response_code(404);
    echo 'No encontrado';
    return true;
}

return false;
