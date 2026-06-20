# Backend alternativo — ASP.NET Core 8

Implementación equivalente de autenticación y CRUD en ASP.NET Core MVC 8.

## Crear el proyecto

Si aún no has generado el proyecto .NET, hazlo dentro de esta carpeta:

```bash
cd src/backend-alt/dotnet-app
dotnet new webapi -n PfcBackend
```

Luego mueve el contenido generado (`Program.cs`, `*.csproj`, etc.) a esta misma carpeta y
organiza el código en:

- `Controllers/` — controladores MVC (rutas de autenticación y CRUD).
- `Models/` — entidades y DTOs.
- `Repositories/` — interfaces e implementaciones con ADO.NET (SqlCommand + SqlParameter).

## Ejecutar

```bash
dotnet run
```

## Seguridad

Usar ASP.NET Core Identity para autenticación (PBKDF2 por defecto), cookies con flags
`HttpOnly`, `Secure`, `SameSite=Strict`, y registrar el repositorio con lifetime `Scoped`.
