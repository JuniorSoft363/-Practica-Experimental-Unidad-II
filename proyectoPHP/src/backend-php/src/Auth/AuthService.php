<?php

declare(strict_types=1);

namespace App\Auth;

/**
 * Lógica de autenticación: registro, login, logout y hashing de contraseñas
 * con password_hash()/password_verify() (Argon2id o bcrypt).
 *
 * Reemplazar este esqueleto con la implementación real del sistema de
 * autenticación descrito en la guía de práctica (OE1).
 */
final class AuthService
{
    public function registrar(string $usuario, string $contrasenaPlano): bool
    {
        $hash = password_hash($contrasenaPlano, PASSWORD_ARGON2ID);
        // TODO: persistir $usuario y $hash mediante el repositorio correspondiente.
        return $hash !== false;
    }

    public function login(string $usuario, string $contrasenaPlano): bool
    {
        // TODO: recuperar el hash almacenado mediante el repositorio y
        // compararlo con password_verify($contrasenaPlano, $hashAlmacenado).
        // Regenerar el ID de sesión tras una autenticación exitosa:
        // session_regenerate_id(true);
        return false;
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
