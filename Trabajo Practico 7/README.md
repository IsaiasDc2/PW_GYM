# Trabajo Práctico 7: CRUD con PHP, PDO y MySQL

Volver al [índice](../README.md)

La entidad del CRUD es **`clases`**, definida en el [TP 6](../Trabajo%20Practico%206/NORMALIZACION.md). El código está integrado al sitio (header, nav y footer del TP 4, Bootstrap y `style.css`) y solo lo puede usar un administrador (ver [TP 8](../Trabajo%20Practico%208/README.md)).

## Estructura pedida vs. real

| Estructura sugerida | En el proyecto |
|---|---|
| `config/conexion.php` | [`config/conexion.php`](../config/conexion.php) |
| `includes/header.php` y `footer.php` | [`includes/`](../includes/) |
| `admin/index.php` (Read) | [`admin/index.php`](../admin/index.php) |
| `admin/crear.php` (Create) | [`admin/crear.php`](../admin/crear.php) |
| `admin/editar.php` (Update) | [`admin/editar.php`](../admin/editar.php) |
| `admin/eliminar.php` (Delete) | [`admin/eliminar.php`](../admin/eliminar.php) |
| `css/` | [`css/`](../css/) |

## Cumplimiento

| Requisito | Estado | Evidencia |
|---|---|---|
| Conexión PDO con `try-catch (PDOException)` | ✅ | `config/conexion.php` |
| Datos de conexión por variables de entorno | ✅ | `DB_*` en [`.env.example`](../.env.example) |
| Integrado a las vistas del sitio | ✅ | Usa `includes/header.php` y `footer.php` |
| Tabla del modelo del TP 6 | ✅ | `clases` con `categorias_clase`, `usuarios` y `sedes` |
| Consultas preparadas con `:parametros` en todo | ✅ | [`app/Models/Clase.php`](../app/Models/Clase.php) y [`app/Models/Catalogo.php`](../app/Models/Catalogo.php) |
| `htmlspecialchars()` en todo lo impreso | ✅ | Función `e()` en [`includes/auth.php`](../includes/auth.php) |
| Validación en servidor | ✅ | Método `validar()` en [`app/Controllers/ClaseController.php`](../app/Controllers/ClaseController.php) |

Mejoras sobre la guía:
- Eliminar se hace por **POST** con token CSRF, no por un enlace GET.
- Crear y editar validan categoría, instructor y sede contra la base de datos.

## Cómo probarlo

1. Habilitar `extension=pdo_mysql` en `php.ini` (en XAMPP y Laragon ya viene activa).
2. Copiar `.env.example` a `.env` y ajustar `DB_PORT` si el motor no usa el 3306.
3. Importar `schema.sql` y `consultas.sql` de [`Trabajo Practico 6`](../Trabajo%20Practico%206/).
4. Crear un administrador: `php tools/crear_admin.php "Nombre" correo@dominio.com "Contraseña1"`.
5. Ejecutar el sitio con `php -S localhost:8000 router.php` (o con XAMPP/Laragon) e ingresar en `login.php` y abrir `admin/index.php`.

## Verificado

Recorrido completo probado en local: alta, edición y baja de una clase, validaciones con datos inválidos y rechazo de la baja con un token CSRF incorrecto.
