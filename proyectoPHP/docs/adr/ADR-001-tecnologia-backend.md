# ADR-001: Selección de Tecnología para el Backend del PFC

| Campo            | Valor                                     |
|------------------|-------------------------------------------|
| **ID**           | ADR-001                                   |
| **Título**       | Selección de tecnología de backend        |
| **Estado**       | Aceptado                                  |
| **Fecha**        | 2026-05-01                                |
| **Autores**      | Figueroa Morales Bryan Javier, Romero Méndez Bryam Steven, Vélez López Ricardo Elías |
| **Revisado por** | Guerrero Ulloa Gleiston Ciceron           |

---

## 1. Contexto

El Proyecto Fin de Curso (PFC) de la asignatura Aplicaciones Web requiere implementar un backend funcional para una aplicación de gestión de inventario denominada **Tienda Stock v2.0**. La guía de la práctica experimental exige el uso de **al menos dos tecnologías de programación del lado del servidor**: PHP 8.x de forma obligatoria, más una segunda tecnología elegida entre ASP.NET Core 8 o Java/Spring Boot 3.

El equipo necesita tomar una decisión técnica documentada sobre qué segunda tecnología complementará a PHP, considerando los siguientes factores contextuales:

- El proyecto se desarrolla en la **Universidad Técnica Estatal de Quevedo**, provincia de Los Ríos, Ecuador.
- El equipo cuenta con experiencia previa principalmente en PHP y JavaScript.
- La infraestructura disponible en el entorno académico incluye equipos con procesador Intel Core i5 o AMD Ryzen 5 con Docker Desktop instalado.
- El plazo de entrega es de 12 horas de laboratorio dentro del periodo 2026-2027 PPA.
- Los requisitos de seguridad incluyen autenticación completa, CRUD con prepared statements, y mitigaciones para OWASP Top 10 A01–A07.

---

## 2. Opciones consideradas

### Opción A — ASP.NET Core 8 MVC

**Descripción:** Framework web de Microsoft basado en .NET 8 LTS. Requiere instalación del SDK .NET 8.0 y Visual Studio o VS Code con C# Dev Kit. Ofrece un pipeline de middleware (UseAuthentication → UseAuthorization) y un sistema de inyección de dependencias nativo con tres lifetimes: Transient, Scoped y Singleton.

**Ventajas:**
- ASP.NET Core Identity incluye hashing PBKDF2/HMACSHA256, protección CSRF y cabeceras de seguridad de fábrica, sin configuración adicional del desarrollador.
- Kestrel (servidor HTTP embebido) es asíncrono y no bloqueante, con rendimiento superior en escenarios de alta concurrencia (~10 000+ req/s en benchmarks independientes).
- Soporte LTS garantizado: .NET 8 recibe soporte hasta noviembre de 2026.
- Integración nativa con Azure y ecosistema NuGet maduro (>300 000 paquetes).

**Desventajas:**
- Curva de aprendizaje media-alta: requiere comprender el pipeline de middleware, DI y conceptos de C#.
- Escasa disponibilidad de hosting compartido en Ecuador; requiere VPS desde aproximadamente $15/mes.
- La comunidad hispanohablante es menor comparada con PHP.
- Menor experiencia previa del equipo en C#.

---

### Opción B — Java/Spring Boot 3.x ✅ *(opción elegida)*

**Descripción:** Framework de nivel empresarial basado en el ecosistema Spring sobre JDK 21 LTS. Utiliza Spring Security (SecurityFilterChain + JWT) para autenticación stateless, Spring Data JPA/Hibernate para acceso a datos, y Maven como gestor de dependencias. El servidor embebido predeterminado es Tomcat 10.

**Ventajas:**
- Spring Security ofrece protecciones integradas: BCryptPasswordEncoder, SecurityFilterChain configurable, y JPQL parametrizado que elimina inyección SQL sin esfuerzo adicional del desarrollador.
- JDK 21 LTS garantiza soporte a largo plazo (hasta septiembre de 2029).
- El ecosistema Maven Central es el más grande del mercado (~3 millones de artefactos), con integración madura en pipelines CI/CD.
- Permite implementar APIs REST stateless con JWT, lo que facilita la integración futura con el frontend de la PE-U1 (SPA o aplicación Blade).
- La arquitectura basada en `@Component`, `@Service`, `@Repository` y `@Autowired` refuerza de forma natural los principios SOLID, en particular DIP e ISP.
- Disponibilidad de herramientas de prueba robustas: `mvn test` con JUnit 5 y Mockito permite verificación automatizada completa.

**Desventajas:**
- Curva de aprendizaje media: requiere entender IoC Container, anotaciones Spring y configuración de Spring Security.
- Hosting en Ecuador requiere VPS o contenedores (Docker); costo aproximado $15–25/mes.
- Verbosidad de JDBC/JPA mayor que PDO en PHP para queries simples (mitigada con Spring Data JPA).
- CSRF deshabilitado en APIs REST stateless: la protección recae en la validación del token JWT.

---

### Opción descartada — Perl/CGI

El equipo consideró brevemente Perl/CGI por su contexto histórico presentado en el fundamento teórico. Fue descartado inmediatamente por las siguientes razones:

- El módulo `CGI.pm` fue eliminado del núcleo de Perl desde la versión 5.22.
- El modelo CGI clásico genera un proceso del SO por cada solicitud HTTP, lo que lo hace inviable bajo carga concurrente.
- No existe un framework dominante equivalente a Spring Boot o Laravel en el ecosistema Perl moderno para desarrollo web.
- Perl no está contemplado como segunda tecnología válida en la guía de la práctica.

---

## 3. Decisión

**Se selecciona Java con Spring Boot 3.x como segunda tecnología**, complementando a PHP 8.x/Laravel como tecnología principal obligatoria.

La decisión se fundamenta en los siguientes criterios determinantes:

1. **Seguridad por defecto:** Spring Security incluye BCryptPasswordEncoder (strength=12), SecurityFilterChain con JWT, y JPQL parametrizado sin configuración explícita adicional, lo que reduce el riesgo de omisiones en controles de seguridad.

2. **Diferenciación arquitectónica:** Spring Boot implementa una arquitectura REST stateless con JWT, mientras que Laravel usa sesiones con estado y tokens CSRF. Esta diferencia permite realizar una comparación técnica objetiva entre dos paradigmas distintos de autenticación, enriqueciendo el análisis comparativo exigido por la guía.

3. **Alineación con principios SOLID:** El IoC Container de Spring refuerza DIP e ISP de forma estructural mediante interfaces (`ProductoService`, `AuthService`) inyectadas en los controladores, nunca implementaciones concretas. Esto es coherente con el patrón Repository implementado en la parte PHP.

4. **Verificación automatizada:** `mvn test` con BUILD SUCCESS (13 tests, 0 fallos) cumple el criterio de verificación del paso 5 y demuestra la calidad del código de forma objetiva.

5. **Experiencia de mercado:** Aunque el mercado ecuatoriano privilegia PHP para proyectos pequeños, el perfil de desarrollador Java/Spring Boot está asociado a entornos empresariales con salarios más altos, lo que aporta valor formativo al equipo.

---

## 4. Consecuencias

### Consecuencias positivas

- La API REST de Spring Boot puede ser consumida por cualquier frontend (incluido el de la PE-U1) mediante peticiones HTTP con cabecera `Authorization: Bearer <token>`, desacoplando completamente frontend y backend.
- Spring Security garantiza que los endpoints sin token retornen HTTP 401 de forma automática, sin código adicional en cada controlador.
- La separación en capas (Controller → Service → Repository) alineada con SOLID facilita la escritura de tests unitarios con Mockito sin necesidad de base de datos real.
- El análisis estático con SonarLint (equivalente a PHPStan en el ecosistema Java) puede aplicarse para verificar calidad del código.

### Consecuencias negativas / riesgos

- El equipo requirió tiempo adicional para configurar Spring Security con JWT en comparación con el sistema de sesiones de Laravel.
- CSRF está deshabilitado en la API REST; si en el futuro se implementa una vista server-side (Thymeleaf), la protección CSRF deberá rehabilitarse explícitamente.
- El costo de hosting para Spring Boot en producción real es significativamente mayor que el de PHP en hosting compartido, lo que limita su viabilidad para proyectos con presupuesto restringido en el contexto ecuatoriano.

---

## 5. Referencias

- C. Walls, *Spring Boot in Action*, 2nd ed. Manning Publications, 2022. ISBN: 978-1-61729-454-7.
- A. Lock, *ASP.NET Core in Action*, 2nd ed. Manning Publications, 2021. ISBN: 978-1-61729-678-7.
- R. Nixon, *Learning PHP, MySQL & JavaScript*, 6th ed. O'Reilly Media, 2021. ISBN: 978-1-492-06229-9.
- OWASP Foundation, "OWASP Top 10:2021," 2021. [En línea]. Disponible: https://owasp.org/Top10/
- VMware / Spring Team, *Spring Security Reference Documentation*, Spring.io, 2025. [En línea]. Disponible: https://docs.spring.io/spring-security/reference/index.html
