<?php
namespace App\Models;

use PDO;

class Clase
{
    public function __construct(private PDO $pdo)
    {
    }

    public function todas(): array
    {
        return $this->pdo->query(
            "SELECT c.id, c.nombre, cat.nombre AS categoria, CONCAT(u.nombre, ' ', u.apellido) AS instructor,
                    s.nombre AS sede, c.dia_semana, c.hora, c.cupo
             FROM clases c
             INNER JOIN categorias_clase cat ON cat.id = c.categoria_id
             INNER JOIN usuarios u ON u.id = c.instructor_id
             INNER JOIN sedes s ON s.id = c.sede_id
             ORDER BY c.id DESC"
        )->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clases WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $clase = $stmt->fetch();
        return $clase ?: null;
    }

    public function crear(array $datos): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO clases (nombre, categoria_id, instructor_id, sede_id, dia_semana, hora, cupo)
             VALUES (:nombre, :categoria_id, :instructor_id, :sede_id, :dia_semana, :hora, :cupo)'
        );
        $stmt->execute($this->parametros($datos));
        return (int) $this->pdo->lastInsertId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE clases
             SET nombre = :nombre, categoria_id = :categoria_id, instructor_id = :instructor_id,
                 sede_id = :sede_id, dia_semana = :dia_semana, hora = :hora, cupo = :cupo
             WHERE id = :id'
        );
        $stmt->execute($this->parametros($datos) + [':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM clases WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    private function parametros(array $datos): array
    {
        return [
            ':nombre' => $datos['nombre'],
            ':categoria_id' => (int) $datos['categoria_id'],
            ':instructor_id' => (int) $datos['instructor_id'],
            ':sede_id' => (int) $datos['sede_id'],
            ':dia_semana' => $datos['dia_semana'],
            ':hora' => $datos['hora'] . ':00',
            ':cupo' => (int) $datos['cupo'],
        ];
    }
}
