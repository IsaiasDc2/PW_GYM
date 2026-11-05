# Trabajo Práctico 6: Normalización y base de datos

Volver al [índice](../README.md)

## Contenido de esta carpeta

| Archivo | Qué pide la consigna |
|---|---|
| [`NORMALIZACION.md`](NORMALIZACION.md) | Parte 1: registro sin normalizar, 1FN, 2FN, 3FN y listado de tablas con PK y FK |
| [`schema.sql`](schema.sql) | Parte 2: script DDL de creación de la base de datos |
| [`consultas.sql`](consultas.sql) | Parte 3: consultas CRUD de prueba |

## Cumplimiento

| Requisito | Estado | Dónde |
|---|---|---|
| Tabla sin normalizar con campos multivalorados | ✅ | `NORMALIZACION.md` |
| 1FN, 2FN y 3FN explicadas | ✅ | `NORMALIZACION.md` |
| Listado de tablas con PK y FK | ✅ | `NORMALIZACION.md` |
| `CREATE DATABASE` + `USE` | ✅ | `schema.sql` |
| Tabla de usuarios con email, password, rol y datos personales | ✅ | `usuarios` |
| Tablas maestras | ✅ | `roles`, `sedes`, `planes`, `categorias_clase` |
| Tabla principal de negocio | ✅ | `clases`, `suscripciones`, `consultas` |
| Tabla de relación N:M | ✅ | `reservas` |
| PK `INT AUTO_INCREMENT` y FK con `REFERENCES` | ✅ | `schema.sql` |
| `created_at` y `updated_at` | ✅ | Tablas principales |
| Al menos un `CREATE INDEX` | ✅ | 4 índices |
| 2 INSERT en maestras y 2 en la principal | ✅ | `consultas.sql` |
| SELECT con WHERE y ORDER BY | ✅ | `consultas.sql` |
| SELECT con INNER JOIN | ✅ | `consultas.sql` (dos consultas) |
| UPDATE con WHERE | ✅ | `consultas.sql` |
| DELETE con WHERE | ✅ | `consultas.sql` |
| Ejecución sin errores en local | ✅ | Probado en MariaDB 11.4 |

## Ejecución

```bash
mysql -u root -e "source Trabajo Practico 6/schema.sql"
mysql -u root -e "source Trabajo Practico 6/consultas.sql"
```

En phpMyAdmin, importar primero `schema.sql` y después `consultas.sql`.

`consultas.sql` crea usuarios de ejemplo con un hash falso, que no sirven para iniciar sesión. Para entrar al sitio, registrate en `registro.php` o creá un administrador con `php tools/crear_admin.php`.
