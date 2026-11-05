<?php
namespace App\Models;

use PDO;

class Catalogo
{
    public function __construct(private PDO $pdo)
    {
    }

    public function todos(): array
    {
        return [
            'categorias' => $this->pdo->query('SELECT id, nombre FROM categorias_clase ORDER BY nombre')->fetchAll(),
            'sedes' => $this->pdo->query('SELECT id, nombre FROM sedes ORDER BY nombre')->fetchAll(),
            'instructores' => $this->pdo->query(
                "SELECT u.id, CONCAT(u.nombre, ' ', u.apellido) AS nombre
                 FROM usuarios u INNER JOIN roles r ON r.id = u.rol_id
                 WHERE r.nombre = 'instructor' ORDER BY u.nombre"
            )->fetchAll(),
        ];
    }
}
