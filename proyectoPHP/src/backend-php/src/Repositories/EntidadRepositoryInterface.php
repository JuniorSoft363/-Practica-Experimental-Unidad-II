<?php

declare(strict_types=1);

namespace App\Repositories;

/**
 * Interfaz de ejemplo para el módulo CRUD principal del PFC.
 * Renombrar según la entidad real del proyecto (p. ej. UsuarioRepositoryInterface).
 */
interface EntidadRepositoryInterface
{
    public function find(int $id): ?array;

    public function findAll(): array;

    public function create(array $datos): int;

    public function update(int $id, array $datos): bool;

    public function delete(int $id): bool;
}
