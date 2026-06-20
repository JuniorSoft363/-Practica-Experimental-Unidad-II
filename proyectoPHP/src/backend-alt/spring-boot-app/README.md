# Backend alternativo — Java / Spring Boot 3

Implementación equivalente de autenticación y CRUD en Spring Boot 3.x.

## Generar el proyecto

Genera el esqueleto con Spring Initializr (https://start.spring.io) con las dependencias:
`Spring Web`, `Spring Security`, `Spring Data JPA` (o JDBC), `MySQL Driver`, `Validation`.

Descomprime el ZIP generado dentro de esta carpeta, de modo que `pom.xml` y `src/main/java/`
queden en esta ubicación.

## Estructura recomendada dentro de `src/main/java/`

```
com/uteq/pfc/
├── controller/     # Controladores REST (autenticación y CRUD)
├── model/          # Entidades JPA
├── repository/     # Interfaces + implementaciones (JDBC con PreparedStatement o Spring Data)
└── security/       # SecurityFilterChain, UserDetailsService, PasswordEncoder
```

## Ejecutar

```bash
mvn spring-boot:run
```

## Seguridad

Configurar Spring Security con `BCryptPasswordEncoder`, `SecurityFilterChain` y
`UserDetailsService` para la autenticación, replicando las mismas reglas de negocio que el
backend PHP.
