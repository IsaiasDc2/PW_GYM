# Trabajo Práctico 8: Sesiones, registro, login y control de acceso

Volver al [índice](../README.md)

## Archivos que pide la consigna

| Consigna | Archivo |
|---|---|
| Registro | [`registro.php`](../registro.php) |
| Login | [`login.php`](../login.php) |
| Guardián de rutas | [`includes/auth_guard.php`](../includes/auth_guard.php) |
| Sesión segura y funciones comunes | [`includes/auth.php`](../includes/auth.php) |
| Logout | [`logout.php`](../logout.php) |
| Vista protegida para cualquier usuario | [`dashboard.php`](../dashboard.php) |
| Vista solo para `admin` | [`admin_panel.php`](../admin_panel.php) y [`admin/`](../admin/) |
| Tabla `usuarios` | [`schema.sql`](../Trabajo%20Practico%206/schema.sql) |
| Crear un administrador | [`tools/crear_admin.php`](../tools/crear_admin.php) |

## Cumplimiento

| Requisito | Estado | Dónde |
|---|---|---|
| Tabla `usuarios` (id, nombre, email único, password 255, rol, created_at) | ✅ | `schema.sql`. El rol está normalizado: `usuarios.rol_id` apunta a `roles` (`admin`, `instructor`, `usuario`) |
| Registro con sanitización | ✅ | `registro.php` |
| Email no repetido | ✅ | `SELECT` previo y captura del error 23000 |
| `password_hash(..., PASSWORD_BCRYPT)` con consulta preparada | ✅ | `registro.php` |
| `password_verify()` | ✅ | `login.php` |
| `session_start()` y `session_regenerate_id(true)` | ✅ | `auth.php` y `login.php` |
| `$_SESSION['usuario_id']`, `['usuario_nombre']`, `['rol']` | ✅ | `login.php` |
| Redirección al panel | ✅ | Admin a `admin_panel.php`, usuario a `dashboard.php` |
| Sin sesión redirige a `login.php?error=acceso_denegado` | ✅ | `auth_guard.php` |
| Al menos dos vistas protegidas, con restricción por rol | ✅ | `dashboard.php`, `admin_panel.php` y `admin/*` |
| Logout: vaciar `$_SESSION`, borrar cookie y `session_destroy()` | ✅ | `logout.php` |
| Integrado a la aplicación principal | ✅ | El menú cambia según la sesión |

Además: tokens CSRF en los formularios POST, mensaje genérico en el login y contraseña de 8 a 72 caracteres con letras y números.

## Pruebas realizadas en local

| Prueba | Resultado |
|---|---|
| Visitante abre `dashboard.php`, `admin_panel.php` o `admin/` | Redirige a `login.php?error=acceso_denegado` |
| Registro con `<script>` en el nombre | Rechazado, no se ejecuta |
| Registro con email repetido | "Ya existe una cuenta" |
| Login con contraseña incorrecta | Mensaje genérico |
| Usuario común abre `admin_panel.php` o `admin/` | Redirige a `dashboard.php?error=sin_permiso` |
| Administrador | Accede al panel y al CRUD |
| Logout y volver a `dashboard.php` | Redirige a login |

## Vulnerabilidades corregidas

| Riesgo | Corrección |
|---|---|
| Fuerza bruta en el login | Tabla `login_intentos`: el login se bloquea 15 minutos tras 5 fallos por email o 30 por IP |
| Cierre de sesión forzado (CSRF) | `logout.php` solo cierra la sesión con POST y token CSRF. Un GET muestra una pantalla de confirmación |
| Sesión robada o fijada | `use_strict_mode`, `use_only_cookies`, cookie `HttpOnly` y `SameSite=Lax`, y regeneración del id al ingresar |
| Sesión abierta sin uso | Se cierra a los 30 minutos de inactividad |
| Rol desactualizado | `auth_guard.php` consulta el rol real en la base en cada petición y cierra la sesión si el usuario ya no existe |
| Contenido protegido en el caché del navegador | `Cache-Control: no-store` en las páginas protegidas |
| XSS, clickjacking y sniffing | Cabeceras `Content-Security-Policy` (solo recursos propios, sin scripts en línea), `X-Frame-Options`, `X-Content-Type-Options` y `Referrer-Policy`. El `onsubmit` del botón Eliminar pasó a `data-confirm` en `main.js` |
| Archivos sensibles descargables (`.env`, `.sql`, `config/`, `includes/`) | `.htaccess` para Apache y `router.php` para el servidor embebido (`php -S localhost:8000 router.php`) |
| Detalle de errores de base de datos en producción | `APP_ENV` por defecto es `production`: el detalle solo se muestra con `APP_ENV=local` |

Pruebas: el sexto intento fallido queda bloqueado (incluso con la clave correcta), el logout sin token no cierra la sesión, `.env` y `schema.sql` devuelven 404, y el recorrido de registro, login, roles y CRUD sigue funcionando.

Queda como mejora fuera del TP: el registro informa que un email ya existe, lo que permite saber qué correos tienen cuenta. La consigna pide esa verificación.
