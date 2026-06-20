# ADR-002: Estrategia de base de datos

## Estado
Propuesto / Aceptado _(elegir uno)_

## Fecha
2026-06-19

## Contexto

_Describir cómo se accederá a la base de datos desde ambas tecnologías: motor elegido
(MySQL/MariaDB, SQL Server, PostgreSQL), mecanismo de acceso (PDO en PHP; ADO.NET o
JDBC en la segunda tecnología) y necesidad de mantener el mismo esquema en ambos backends._

## Decisión

_Motor de base de datos elegido, estrategia de migración/versionado del esquema, y patrón de
acceso a datos (Repository) utilizado en ambas implementaciones._

## Alternativas consideradas

| Alternativa | Ventajas | Desventajas |
|---|---|---|
| MySQL/MariaDB | | |
| SQL Server | | |
| PostgreSQL | | |

## Consecuencias

_Impacto en seguridad (prepared statements), portabilidad entre tecnologías, y facilidad de
prueba (repositorio en memoria para tests unitarios)._

## Referencias

- OWASP SQL Injection Prevention Cheat Sheet
- Documentación oficial de PDO / ADO.NET / JDBC
