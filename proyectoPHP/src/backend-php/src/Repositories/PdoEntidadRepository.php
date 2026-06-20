<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use PDOException;

/**
 * Implementación concreta con PDO y prepared statements.
 * Ninguna consulta debe construirse por concatenación de strings.
 */
final class PdoEntidadRepository implements EntidadRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM entidad WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado !== false ? $resultado : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM entidad');

        return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function create(array $datos): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO entidad (campo1, campo2) VALUES (:campo1, :campo2)'
        );
        $stmt->bindValue(':campo1', $datos['campo1'] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':campo2', $datos['campo2'] ?? '', PDO::PARAM_STR);

        try {
            $stmt->execute();
            return (int) $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function update(int $id, array $datos): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE entidad SET campo1 = :campo1, campo2 = :campo2 WHERE id = :id'
        );
        $stmt->bindValue(':campo1', $datos['campo1'] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':campo2', $datos['campo2'] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM entidad WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
