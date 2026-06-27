# ADR-002: Estrategia de Base de Datos y Acceso a Datos

| Campo            | Valor                                     |
|------------------|-------------------------------------------|
| **ID**           | ADR-002                                   |
| **Título**       | Motor de base de datos, estrategia de acceso a datos y patrón de abstracción |
| **Estado**       | Aceptado                                  |
| **Fecha**        | 2026-05-01                                |
| **Autores**      | Figueroa Morales Bryan Javier, Romero Méndez Bryam Steven, Vélez López Ricardo Elías |
| **Revisado por** | Guerrero Ulloa Ciceron                    |

---

## 1. Contexto

El backend del PFC (Tienda Stock v2.0) requiere un sistema de persistencia que soporte las siguientes entidades: `users`, `categorias` y `productos`. Ambas implementaciones tecnológicas (PHP/Laravel y Java/Spring Boot) deben compartir el mismo motor de base de datos para validar la equivalencia funcional del CRUD en ambas plataformas.

La guía de la práctica establece los siguientes requisitos no negociables para la capa de acceso a datos:

- **Cero concatenación de strings** en la construcción de queries SQL. Todo acceso a datos debe usar prepared statements o JPQL parametrizado.
- **Patrón Repository** con interfaz y clase concreta en PHP: `ProductoRepositoryInterface` e implementación `PdoProductoRepository`.
- **PDO configurado** con `ATTR_ERRMODE = ERRMODE_EXCEPTION`, `ATTR_DEFAULT_FETCH_MODE = FETCH_ASSOC` y `ATTR_EMULATE_PREPARES = false`.
- **Conexión con charset `utf8mb4`** para soporte completo de Unicode (incluyendo emojis y caracteres especiales del español).
- Mitigación de OWASP A03 (Inyección) verificada mediante revisión de código por el docente.

Adicionalmente, la arquitectura debe permitir pruebas unitarias que no dependan de una base de datos real (repositorio en memoria como doble de prueba).

---

## 2. Opciones consideradas para el motor de base de datos

### Opción A — MySQL 8.x / MariaDB 10.x

**Descripción:** Motor relacional ampliamente utilizado en hosting compartido con cPanel. Es el motor predeterminado de XAMPP y Laragon, y el más común en el ecosistema PHP latinoamericano.

**Ventajas:**
- Disponibilidad universal en hosting compartido ecuatoriano (desde $3/mes con cPanel).
- Configuración trivial en XAMPP y Laragon.
- Documentación extensa en español.
- Compatibilidad nativa con Laravel Eloquent y PDO sin configuración adicional.

**Desventajas:**
- `ATTR_EMULATE_PREPARES = false` puede causar problemas con placeholders tipados en algunas versiones del driver PDO MySQL, especialmente con parámetros LIMIT/OFFSET de tipo entero en consultas paginadas.
- Spring Boot requiere configuración del driver `mysql-connector-j` en `pom.xml`; la dependencia está sujeta a actualizaciones frecuentes de licenciamiento por parte de Oracle.
- Menos características avanzadas de integridad referencial comparado con PostgreSQL (p. ej., soporte parcial de CHECK constraints antes de MySQL 8.0.16).

---

### Opción B — PostgreSQL 15+ ✅ *(opción elegida)*

**Descripción:** Motor de base de datos objeto-relacional de código abierto, con soporte completo de SQL estándar, tipos de datos avanzados (JSONB, arrays, UUID), integridad referencial estricta y extensiones como `pgcrypto`. Disponible como imagen Docker oficial y preinstalado en entornos cloud modernos.

**Ventajas:**
- `ATTR_EMULATE_PREPARES = false` funciona correctamente con el driver `pdo_pgsql` incluyendo placeholders tipados enteros (LIMIT, OFFSET), sin workarounds.
- Soporte nativo del operador `ILIKE` para búsquedas case-insensitive en castellano sin funciones adicionales.
- Spring Boot + Spring Data JPA + Hibernate se integran de forma transparente con PostgreSQL sin configuración adicional al cambiar `spring.datasource.url`.
- HikariCP (pool de conexiones predeterminado en Spring Boot) gestiona automáticamente el pool con PostgreSQL, sin código explícito del desarrollador.
- Comunidad activa y versiones LTS predecibles (PostgreSQL 15 con soporte hasta noviembre 2027).
- Uso de `pgAdmin 4` o `DBeaver` (mencionados en los materiales de la guía) para administración visual.

**Desventajas:**
- No disponible nativamente en XAMPP; requiere instalación separada o Docker.
- El driver PDO para PostgreSQL (`pdo_pgsql`) debe estar habilitado en `php.ini`; en Laragon esto requiere edición manual.
- Menor disponibilidad en hosting compartido ecuatoriano de bajo costo.

---

### Opción descartada — SQLite

SQLite fue descartado por no ser compatible con múltiples conexiones concurrentes en producción, y porque Laragon y Docker con PHP-FPM generan múltiples workers que podrían colisionar al escribir en el mismo archivo SQLite. Tampoco soporta el operador `ILIKE` nativo ni el tipo `SERIAL`/`BIGSERIAL` requerido para las claves primarias auto-incrementales en las entidades del PFC.

---

## 3. Opciones consideradas para la estrategia de acceso a datos

### Opción X — Active Record (Eloquent de Laravel únicamente)

**Descripción:** El ORM de Laravel permite que el modelo de dominio extienda `Model` y se persista directamente. Las queries se construyen mediante el Query Builder de Eloquent, que internally usa PDO con prepared statements.

**Ventajas:**
- Menor cantidad de código boilerplate para CRUDs simples.
- Integración transparente con validaciones de Laravel Form Requests.

**Desventajas:**
- El objeto de dominio queda acoplado al mecanismo de persistencia: viola el Principio de Responsabilidad Única (SRP).
- Dificulta las pruebas unitarias: para testear la lógica de negocio se requiere una base de datos real o un mock complejo del modelo Eloquent.
- No cumple el requisito de la guía de separar interfaz y clase concreta mediante el patrón Repository.
- No es transferible a Spring Boot; ambas implementaciones quedarían arquitectónicamente incomparables.

---

### Opción Y — PDO puro (PHP) + JPQL/JPA (Java) con patrón Repository ✅ *(opción elegida)*

**Descripción:** En PHP, se implementa una interfaz `ProductoRepositoryInterface` y una clase concreta `PdoProductoRepository implements ProductoRepositoryInterface` que contiene exclusivamente el código SQL parametrizado con PDO. En Java/Spring Boot, se utiliza `JpaRepository<Producto, Long>` extendido con queries JPQL parametrizadas mediante la anotación `@Query` y `@Param`.

**Ventajas:**

- **Cumplimiento de SOLID:**
  - *SRP:* El repositorio solo sabe cómo acceder a los datos; el servicio solo contiene lógica de negocio; el controlador solo coordina la petición HTTP.
  - *OCP:* Se puede agregar una implementación en memoria (`InMemoryProductoRepository`) sin modificar `ProductoController` ni `ProductoService`.
  - *DIP:* El controlador depende de `ProductoRepositoryInterface`, no de `PdoProductoRepository`.

- **Prevención de inyección SQL estructural:**
  - En PHP, PDO con `ATTR_EMULATE_PREPARES = false` garantiza que el motor de base de datos compile el plan de query antes de recibir los datos del usuario. Los métodos `bindValue()` vinculan el tipo PDO explícitamente (`PDO::PARAM_INT`, `PDO::PARAM_STR`).
  - En Java, JPQL parametrizado (`:nombre`, `:categoriaId`) nunca interpreta los parámetros como sintaxis SQL, independientemente de su contenido.

- **Testabilidad:**
  - En PHP: se puede inyectar un repositorio en memoria que implemente `ProductoRepositoryInterface` en las pruebas unitarias, sin necesidad de base de datos.
  - En Java: Mockito permite crear un mock de `ProductoRepository` con `@MockBean`, lo que habilita tests de servicio sin contexto de persistencia real.

- **Comparabilidad entre tecnologías:** La misma interfaz de dominio (crear, findById, findAll, update, delete) está implementada en ambas plataformas, lo que hace la comparación técnica de la tabla Cuadro 1 del informe directamente válida.

**Desventajas:**
- Mayor cantidad de código boilerplate en PHP comparado con Eloquent para CRUDs simples.
- El binding con `RepositoryServiceProvider` en Laravel requiere registro explícito: `$this->app->bind(ProductoRepositoryInterface::class, PdoProductoRepository::class)`.
- La hidratación manual de modelos Eloquent (`Producto::hydrate($rows)`) en `PdoProductoRepository` es un acoplamiento residual a Eloquent que podría eliminarse en un refactor posterior con DTOs puros.

---

## 4. Decisión

**Se selecciona PostgreSQL 15+ como motor de base de datos compartido para ambas tecnologías**, y **el patrón Repository con PDO (PHP) y JPA/JPQL (Java) como estrategia de acceso a datos**.

### Justificación de la combinación elegida

La combinación PostgreSQL + Patrón Repository es la que mejor satisface simultáneamente los tres requisitos no negociables de la guía:

| Requisito de la guía | Cómo lo satisface la decisión |
|---|---|
| Cero concatenación SQL | PDO `bindValue()` + JPQL `@Param` eliminan la concatenación a nivel estructural |
| Interfaz + clase concreta (Repository) | `ProductoRepositoryInterface` / `PdoProductoRepository` en PHP; `JpaRepository` en Java |
| PDO configurado correctamente | `ERRMODE_EXCEPTION`, `FETCH_ASSOC`, `EMULATE_PREPARES=false` funcionan sin workarounds con `pdo_pgsql` |
| OWASP A03 mitigado | Separación de plan de query y datos de usuario garantizada por ambos drivers |
| Tests automatizados | Mockito (Java) y repositorios en memoria (PHP) habilitados por el desacoplamiento vía interfaz |

---

## 5. Esquema de la base de datos resultante

Las tres tablas del PFC comparten el mismo esquema en PostgreSQL para ambas implementaciones:

```sql
-- Tabla de usuarios (compartida)
CREATE TABLE users (
    id         BIGSERIAL PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,  -- hash Argon2id (PHP) o BCrypt strength=12 (Java)
    role       VARCHAR(50)  NOT NULL DEFAULT 'ROLE_USER',
    created_at TIMESTAMP WITHOUT TIME ZONE,
    updated_at TIMESTAMP WITHOUT TIME ZONE
);

-- Tabla de categorías
CREATE TABLE categorias (
    id          BIGSERIAL PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla de productos
CREATE TABLE productos (
    id           BIGSERIAL PRIMARY KEY,
    nombre       VARCHAR(200) NOT NULL,
    precio       NUMERIC(10, 2) NOT NULL,
    stock        INTEGER NOT NULL DEFAULT 0,
    categoria_id BIGINT REFERENCES categorias(id),
    created_at   TIMESTAMP WITHOUT TIME ZONE,
    updated_at   TIMESTAMP WITHOUT TIME ZONE
);
```

> **Nota:** El campo `password` almacena hashes de algoritmos distintos según la tecnología. PHP usa `password_hash($pwd, PASSWORD_ARGON2ID)` (prefijo `$argon2id$`); Java usa `BCryptPasswordEncoder(strength=12)` (prefijo `$2a$12$`). Ambos formatos son legibles en PostgreSQL como `VARCHAR(255)` y no son intercambiables entre plataformas; cada implementación valida únicamente los hashes que ella misma genera.

---

## 6. Consecuencias

### Consecuencias positivas

- La verificación del criterio del paso 3 (ninguna query usa concatenación de strings) es directamente comprobable por el docente mediante revisión del código de `PdoProductoRepository`.
- El operador `ILIKE` de PostgreSQL permite búsquedas por nombre de producto case-insensitive en castellano sin conversión explícita a mayúsculas/minúsculas.
- La captura N19 del anexo Java (tablas en DBeaver) evidencia que ambas aplicaciones comparten la misma instancia de PostgreSQL, lo que valida la equivalencia funcional del CRUD.
- La separación mediante interfaz permite que en iteraciones futuras del PFC se pueda agregar un repositorio caché (Redis) sin modificar ningún controlador ni servicio existente.

### Consecuencias negativas / riesgos

- La hidratación de modelos Eloquent dentro de `PdoProductoRepository` (`Producto::hydrate($rows)`) introduce un acoplamiento residual a Eloquent. Si en el futuro el equipo decide migrar a un framework PHP distinto (Symfony, Slim), deberá refactorizar la hidratación hacia DTOs puros.
- La configuración de `pdo_pgsql` en Laragon requirió edición manual del `php.ini`, paso que no está documentado en la guía y que puede ser un obstáculo para reproducir el entorno en otras máquinas. Se recomienda agregar esta instrucción al `README.md` del repositorio.
- JPQL parametrizado cubre el 100% de las queries en Spring Boot, pero si en el futuro se requieren queries nativas con `@Query(nativeQuery = true)`, el riesgo de inyección reaparece si no se usan `@Param` correctamente.

---

## 7. Referencias

- L. Welling and L. Thomson, *PHP and MySQL Web Development*, 5th ed. Addison-Wesley, 2016. ISBN: 978-0-321-83389-1.
- OWASP Foundation, "SQL Injection Prevention Cheat Sheet," 2024. [En línea]. Disponible: https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html
- The PHP Group, *PHP: PDO::prepare - Manual*, PHP Manual, 2026. [En línea]. Disponible: https://www.php.net/manual/en/pdo.prepare.php
- R. C. Martin, *Clean Code: A Handbook of Agile Software Craftsmanship*. Prentice Hall, 2008. ISBN: 978-0-13-235088-4.
- Oracle, *JDBC Basics - The Java Tutorials*, Oracle Java Documentation, 2024. [En línea]. Disponible: https://docs.oracle.com/javase/tutorial/jdbc/basics/index.html
- VMware / Spring Team, *Spring Boot Reference Documentation*, Spring.io, 2025. [En línea]. Disponible: https://docs.spring.io/spring-boot/index.html
