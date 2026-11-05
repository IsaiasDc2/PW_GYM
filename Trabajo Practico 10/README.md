# Trabajo Práctico 10: Refactorización a MVC e implementación con framework

Volver al [índice](../README.md)

El trabajo tiene dos entregas complementarias:

- **Parte A:** el CRUD de clases que ya existía en [`admin/`](../admin/) se refactorizó a MVC nativo con las carpetas [`app/Models`](../app/Models/), [`app/Views`](../app/Views/) y [`app/Controllers`](../app/Controllers/).
- **Parte B:** se creó un proyecto independiente con **Laravel 13** en [`tp10-laravel/`](../tp10-laravel/) que implementa un CRUD de **sedes** con Routing, Controlador, Modelo Eloquent y vistas Blade.

## Parte A: MVC nativo

### Estructura

| Capa | Archivo | Responsabilidad |
|---|---|---|
| Modelo | [`app/Models/Clase.php`](../app/Models/Clase.php) | Consultas SQL de clases con PDO y consultas preparadas |
| Modelo | [`app/Models/Catalogo.php`](../app/Models/Catalogo.php) | Consultas de categorías, instructores y sedes |
| Controlador | [`app/Controllers/ClaseController.php`](../app/Controllers/ClaseController.php) | Request, CSRF, validación, redirecciones y mensajes |
| Controlador base | [`app/Controllers/Controller.php`](../app/Controllers/Controller.php) | Renderizado de vistas |
| Vistas | [`app/Views/clases/`](../app/Views/clases/) | HTML limpio, formulario y tabla de clases |
| Autoload | [`app/autoload.php`](../app/autoload.php) | Carga automática de las clases con namespace `App\` |
| Puntos de entrada | [`admin/`](../admin/) | Archivos delgados que delegan en el controlador |

Las URLs públicas no cambiaron:

```
admin/index.php          → ClaseController@index
admin/crear.php          → ClaseController@crear
admin/editar.php?id=...  → ClaseController@editar
admin/eliminar.php       → ClaseController@eliminar (solo POST + CSRF)
```

`admin/index.php`, `crear.php`, `editar.php` y `eliminar.php` solo incluyen `_bootstrap.php` y llaman al método del controlador. La autenticación y el rol `admin` siguen a cargo de `includes/auth_guard.php`, por lo que el comportamiento y la seguridad no cambian.

### Separación aplicada

- **Modelos:** no imprimen HTML ni leen `$_POST`; solo reciben datos y ejecutan SQL con `prepare()` / `execute()`.
- **Controlador:** no contiene SQL ni etiquetas HTML; valida, maneja CSRF y decide la vista o la redirección.
- **Vistas:** no ejecutan consultas; reciben arreglos ya preparados y escapan con `e()`.

## Parte B: Laravel 13

Proyecto: [`tp10-laravel/`](../tp10-laravel/). Es un entorno Laravel independiente, con su propia base SQLite y su propio servidor.

### Módulo implementado: CRUD de sedes

| Elemento | Archivo |
|---|---|
| Rutas | [`routes/web.php`](../tp10-laravel/routes/web.php) |
| Controlador | [`app/Http/Controllers/SedeController.php`](../tp10-laravel/app/Http/Controllers/SedeController.php) |
| Modelo Eloquent | [`app/Models/Sede.php`](../tp10-laravel/app/Models/Sede.php) |
| Migración | [`database/migrations/2026_11_05_142839_create_sedes_table.php`](../tp10-laravel/database/migrations/2026_11_05_142839_create_sedes_table.php) |
| Seeder | [`database/seeders/SedeSeeder.php`](../tp10-laravel/database/seeders/SedeSeeder.php) |
| Vistas Blade | [`resources/views/sedes/`](../tp10-laravel/resources/views/sedes/) y [`layouts/app.blade.php`](../tp10-laravel/resources/views/layouts/app.blade.php) |

Rutas generadas con `Route::resource('sedes', SedeController::class)`:

| Método | URI | Acción |
|---|---|---|
| GET | `/sedes` | Listado |
| GET | `/sedes/create` | Formulario de alta |
| POST | `/sedes` | Guardar |
| GET | `/sedes/{sede}` | Detalle |
| GET | `/sedes/{sede}/edit` | Formulario de edición |
| PUT/PATCH | `/sedes/{sede}` | Actualizar |
| DELETE | `/sedes/{sede}` | Eliminar |

La raíz `/` redirige a `/sedes`. Las operaciones de escritura usan `@csrf` y `@method` en Blade, y el controlador valida con `$request->validate()` y mensajes en español.

### Cómo ejecutar el módulo Laravel

Requisitos: PHP 8.3 o superior, extensiones `pdo_sqlite` y `sqlite3`, y Composer. La carpeta `vendor/` no se versiona.

```bash
cd tp10-laravel
composer install
copy .env.example .env
php artisan key:generate
```

Crear la base SQLite y cargar las sedes de ejemplo:

```bash
# Windows (PowerShell)
New-Item database/database.sqlite -ItemType File -Force
# Linux/macOS
touch database/database.sqlite

php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8002
```

Abrir `http://127.0.0.1:8002/` (redirige a `/sedes`).

Alternativa sin `artisan serve`:

```bash
php -S 127.0.0.1:8002 -t public public/index.php
```

## Cómo probar la Parte A

1. Habilitar `pdo_mysql` en PHP.
2. Importar la base de [`Trabajo Practico 6`](../Trabajo%20Practico%206/).
3. Crear un administrador si no existe:
   ```bash
   php tools/crear_admin.php "Admin" admin@forjagym.com.ar "Contraseña1"
   ```
4. Levantar el sitio:
   ```bash
   php -S localhost:8001 router.php
   ```
5. Ingresar en `login.php` y abrir `admin/index.php`.

## Pruebas realizadas

### MVC nativo

| Prueba | Resultado |
|---|---|
| Listado `admin/index.php` | Muestra las clases con categoría, instructor, sede, día, hora y cupo |
| Alta de una clase | Inserta y redirige con `?status=created` |
| Edición de una clase | Actualiza y redirige con `?status=updated` |
| Baja con POST + CSRF | Elimina y redirige con `?status=deleted` |
| Formulario vacío | Muestra 6 errores de validación y conserva los valores |
| Visitante sin sesión | Redirige a login (guardián sin cambios) |

### Laravel

| Prueba | Resultado |
|---|---|
| `GET /` | Redirige a `/sedes` |
| `GET /sedes` | Lista las 3 sedes del seeder |
| `POST /sedes` | Crea una sede y muestra “Sede creada correctamente.” |
| `PUT /sedes/{id}` | Actualiza y muestra “Sede actualizada correctamente.” |
| Nombre duplicado | Error “Ya existe una sede con ese nombre.” |
| `DELETE /sedes/{id}` | Elimina y muestra “Sede eliminada correctamente.” |
| `GET /sedes/{id}` | Muestra el detalle de la sede |

## Git

Commit sugerido para esta entrega:

```bash
git add app admin .htaccess router.php tp10-laravel "Trabajo Practico 10" README.md
git commit -m "feat: refactorizacion MVC e implementacion de modulo con framework"
```
