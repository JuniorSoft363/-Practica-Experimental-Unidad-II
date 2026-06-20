<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// Punto de entrada (front controller) del backend PHP.
// Aquí se inicializa el enrutador, la conexión PDO (config/) y las rutas
// de autenticación (src/Auth) y CRUD (src/Repositories).

session_start();

header('Content-Type: text/plain; charset=utf-8');
echo "Backend PHP activo. Reemplazar con el enrutador real del proyecto.";
