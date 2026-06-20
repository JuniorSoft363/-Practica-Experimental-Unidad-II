<?php

declare(strict_types=1);

// Configuración de conexión PDO segura.
// Recomendado: cargar estos valores desde variables de entorno (.env), nunca
// hardcodeados ni versionados en el repositorio.

return [
    'driver'   => $_ENV['DB_DRIVER']   ?? 'mysql',
    'host'     => $_ENV['DB_HOST']     ?? '127.0.0.1',
    'port'     => $_ENV['DB_PORT']     ?? '3306',
    'database' => $_ENV['DB_DATABASE'] ?? 'pfc_db',
    'username' => $_ENV['DB_USERNAME'] ?? 'pfc_user',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
    'charset'  => 'utf8mb4',
    'options'  => [
        // PDO::ERRMODE_EXCEPTION, PDO::FETCH_ASSOC, etc.
    ],
];
