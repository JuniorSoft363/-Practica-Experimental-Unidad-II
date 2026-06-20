<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Contrato genérico de repositorio. Cada entidad del PFC debe definir su
 * propia interfaz específica (p. ej. UsuarioRepositoryInterface) que extienda
 * o se modele sobre esta base, manteniendo el patrón Repository sin
 * concatenación de SQL en ningún punto de la aplicación.
 */
interface RepositoryInterface
{
    public function find(int $id): ?array;

    public function findAll(): array;

    public function create(array $datos): int;

    public function update(int $id, array $datos): bool;

    public function delete(int $id): bool;
}
