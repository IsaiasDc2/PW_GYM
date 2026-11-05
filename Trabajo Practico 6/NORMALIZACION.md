# TP 6: Normalización y modelo de datos (Forja Gym)

## Parte 1: Normalización

### 1. Registro sin normalizar

Tabla única `inscripciones` con los datos de un socio, su plan, las clases a las que se anotó y la sede.

| id | socio | email | telefonos | plan | precio_plan | clases_reservadas | instructores | sede | direccion_sede |
|---|---|---|---|---|---|---|---|---|---|
| 1 | Isaías Socio | socio1@mail.com | 1155550003, 1144440000 | Pro | 29900 | Funcional AM, Yoga Flow | Lucía Gómez, Lucía Gómez | Forja Centro | Av. Principal 100 |
| 2 | Marta Pérez | socio2@mail.com | 1155550004 | Básico | 18900 | WOD CrossFit | Diego Torres | Forja Norte | Calle Norte 200 |

Problemas:
- `telefonos`, `clases_reservadas` e `instructores` guardan varios valores en una sola celda.
- El precio del plan, la dirección de la sede y el instructor se repiten en cada fila.
- Cambiar el precio del plan obliga a modificar muchas filas.

### 2. Proceso

**1FN (valores atómicos, sin grupos repetidos).** Se separa cada valor en su propia fila. Clave primaria compuesta: (`id_socio`, `clase`).

| id_socio | socio | email | telefono | plan | precio_plan | clase | instructor | sede | direccion_sede |
|---|---|---|---|---|---|---|---|---|---|
| 1 | Isaías Socio | socio1@mail.com | 1155550003 | Pro | 29900 | Funcional AM | Lucía Gómez | Forja Centro | Av. Principal 100 |
| 1 | Isaías Socio | socio1@mail.com | 1155550003 | Pro | 29900 | Yoga Flow | Lucía Gómez | Forja Centro | Av. Principal 100 |
| 2 | Marta Pérez | socio2@mail.com | 1155550004 | Básico | 18900 | WOD CrossFit | Diego Torres | Forja Norte | Calle Norte 200 |

**2FN (sin dependencias parciales de la clave).** Con la clave (`id_socio`, `clase`):
- `socio`, `email`, `telefono`, `plan`, `precio_plan` dependen solo de `id_socio`. Pasan a la tabla **usuarios** (y `plan` a **suscripciones**).
- `instructor`, `sede`, `direccion_sede` dependen solo de `clase`. Pasan a la tabla **clases**.
- Queda la relación socio-clase en **reservas**.

**3FN (sin dependencias transitivas).**
- `precio_plan` depende de `plan`, que no es la clave: tabla **planes**.
- `direccion_sede` depende de `sede`: tabla **sedes**.
- `categoria` de la clase pasa a **categorias_clase**.
- El rol del usuario (admin, instructor, usuario) pasa a **roles**.
- El instructor es un usuario con rol `instructor`, no un dato duplicado.

### 3. Tablas resultantes

| Tabla | PK | FK |
|---|---|---|
| `roles` | `id` | |
| `sedes` | `id` | |
| `planes` | `id` | |
| `categorias_clase` | `id` | |
| `usuarios` | `id` | `rol_id` → roles, `sede_id` → sedes |
| `clases` | `id` | `categoria_id` → categorias_clase, `instructor_id` → usuarios, `sede_id` → sedes |
| `suscripciones` | `id` | `usuario_id` → usuarios, `plan_id` → planes |
| `reservas` | `id` (único: usuario, clase, fecha) | `usuario_id` → usuarios, `clase_id` → clases |
| `consultas` | `id` | `sede_id` → sedes |

Relaciones: usuarios N:M clases (por `reservas`), usuarios N:M planes (por `suscripciones`).

```
roles 1──N usuarios N──1 sedes
usuarios 1──N clases N──1 categorias_clase
usuarios N──M clases   (reservas)
usuarios N──M planes   (suscripciones)
sedes 1──N clases
sedes 1──N consultas
```

El campo `rol` que pide el TP 8 (`'admin'` / `'usuario'`) queda normalizado: `usuarios.rol_id` apunta a `roles.nombre`, y el login lo trae con un `INNER JOIN` para guardarlo en `$_SESSION['rol']`.

## Parte 2 y 3: Scripts

- [`schema.sql`](schema.sql): base `forja_gym`, 9 tablas, claves foráneas, campos `created_at`/`updated_at` e índices (`CREATE INDEX`).
- [`consultas.sql`](consultas.sql): INSERT, SELECT con WHERE/ORDER BY, SELECT con INNER JOIN, UPDATE y DELETE con WHERE.

Ejecución local (MySQL/MariaDB):

```bash
mysql -u root -e "source Trabajo Practico 6/schema.sql"
mysql -u root -e "source Trabajo Practico 6/consultas.sql"
```

Los dos scripts se probaron sin errores en MariaDB 11.4.

Los usuarios de `consultas.sql` tienen un hash de ejemplo y no sirven para iniciar sesión. Para entrar al sitio, registrate en `registro.php` o creá un administrador con `php tools/crear_admin.php`.
