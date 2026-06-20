# Mi Proyecto PFC — Backend Aplicaciones Web

Proyecto Fin de Curso para la asignatura **Aplicaciones Web [111]** — UTEQ, Facultad de Ciencias de la Computación.

Implementa el backend con dos tecnologías de programación del lado del servidor:

- **PHP 8.x** (obligatorio) — autenticación segura, CRUD con PDO y patrón Repository.
- **ASP.NET Core 8 o Java/Spring Boot 3** (segunda tecnología, elegir una) — misma funcionalidad replicada.

## Estructura del repositorio

```
mi-proyecto-pfc/
├── .github/workflows/    # CI/CD opcional (PHPStan automático)
├── docs/
│   ├── adr/               # Architecture Decision Records
│   ├── diagrams/           # Diagramas de flujo y E-R
│   └── informe/            # Informe técnico/científico (PDF)
├── src/
│   ├── backend-php/        # Implementación obligatoria en PHP 8.x
│   └── backend-alt/        # Segunda tecnología (dotnet-app o spring-boot-app)
├── docker/                 # Configuración de contenedores
└── README.md
```

## Cómo ejecutar

### Backend PHP

```bash
cd src/backend-php
composer install
php -S localhost:8080 -t public
```

O con Docker:

```bash
cd docker
docker compose up -d
```

Verificación: `http://localhost:8080/index.php` debe responder con HTTP 200.

### Segunda tecnología

- **ASP.NET Core**: ver `src/backend-alt/dotnet-app/README.md` (pendiente de completar).
- **Spring Boot**: ver `src/backend-alt/spring-boot-app/README.md` (pendiente de completar).

## Documentación de decisiones (ADR)

Las decisiones arquitectónicas relevantes están documentadas en `docs/adr/`:

- [ADR-001 — Tecnología de backend](docs/adr/ADR-001-tecnologia-backend.md)
- [ADR-002 — Estrategia de base de datos](docs/adr/ADR-002-estrategia-bd.md)

## Análisis estático

El código PHP se valida con PHPStan nivel 5 (`src/backend-php/phpstan.neon`):

```bash
cd src/backend-php
vendor/bin/phpstan analyse
```

## Autores

- _Completar con los integrantes del equipo_

## Asignatura

Aplicaciones Web [111] — 5to Nivel A — Periodo 2026-2027 PPA
Docente: Guerrero Ulloa Gleiston Ciceron
