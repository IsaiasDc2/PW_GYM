# Módulo Sedes — Laravel 13

Módulo independiente del Trabajo Práctico 10. Implementa un CRUD de sedes con:

- Routing por `Route::resource`.
- Controlador `App\Http\Controllers\SedeController`.
- Modelo Eloquent `App\Models\Sede`.
- Migración y seeder de la tabla `sedes`.
- Vistas Blade con un layout propio.

## Puesta en marcha

Requisitos: PHP 8.3+, extensiones `pdo_sqlite` y `sqlite3`, y Composer.

```bash
composer install
copy .env.example .env
php artisan key:generate
```

Crear la base SQLite:

```powershell
New-Item database/database.sqlite -ItemType File -Force
```

```bash
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8002
```

Abrir `http://127.0.0.1:8002/`.

## Rutas

| Método | URI | Acción |
|---|---|---|
| GET | `/sedes` | Listado |
| GET | `/sedes/create` | Alta |
| POST | `/sedes` | Guardar |
| GET | `/sedes/{sede}` | Detalle |
| GET | `/sedes/{sede}/edit` | Edición |
| PUT/PATCH | `/sedes/{sede}` | Actualizar |
| DELETE | `/sedes/{sede}` | Eliminar |

La base SQLite, el archivo `.env` y `vendor/` están excluidos del repositorio.
