<?php
if (PHP_SAPI !== 'cli') {
    exit('Solo se puede ejecutar desde la línea de comandos.');
}
require_once __DIR__ . '/../config/conexion.php';

[, $nombre, $email, $password] = $argv + [null, null, null, null];
if (!$nombre || !$email || !$password) {
    exit("Uso: php tools/crear_admin.php \"Nombre\" email@dominio.com \"Contraseña\"\n");
}

$stmt = $pdo->prepare(
    "INSERT INTO usuarios (nombre, email, password, rol_id)
     VALUES (:nombre, :email, :password, (SELECT id FROM roles WHERE nombre = 'admin'))"
);
$stmt->execute([
    ':nombre' => $nombre,
    ':email' => mb_strtolower($email),
    ':password' => password_hash($password, PASSWORD_BCRYPT),
]);
echo "Administrador creado: $email\n";
