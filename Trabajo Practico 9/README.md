# Trabajo Práctico 9: Comunicación asincrónica y APIs (AJAX & JSON)

Volver al [índice](../README.md)

La funcionalidad está integrada en [`clases.php`](../clases.php): un buscador en vivo consulta la tabla `clases` de MySQL mediante Fetch API y actualiza los resultados sin recargar la página. La sección estática de clases y el resto del sitio quedaron sin cambios.

## Archivos de la entrega

| Consigna | Archivo |
|---|---|
| Endpoint PHP que responde JSON | [`api/clases.php`](../api/clases.php) |
| Consumo asincrónico y manejo de errores | [`js/clases-api.js`](../js/clases-api.js) |
| Interfaz integrada al sitio | Sección `#buscador-clases` en [`clases.php`](../clases.php) |
| Conexión y consultas preparadas | PDO con `config/env.php` y la tabla `clases` del [TP 6](../Trabajo%20Practico%206/schema.sql) |

## Cumplimiento

| Requisito | Estado | Dónde |
|---|---|---|
| Endpoint PHP independiente | ✅ | `api/clases.php` |
| `Content-Type: application/json; charset=utf-8` | ✅ | `api/clases.php` |
| Consulta a MySQL con PDO y consultas preparadas | ✅ | `api/clases.php`: `prepare()` + parámetros nombrados |
| Arreglo PHP convertido con `json_encode()` | ✅ | Respuesta `{status, total, query, categoria, data}` |
| Códigos HTTP apropiados | ✅ | 200, 400, 405 y 500 según el caso |
| Evento del usuario capturado con JavaScript | ✅ | Evento `input` en el buscador y `change` en la categoría |
| Petición asincrónica con Fetch API | ✅ | `fetch()` con `async` / `await` y `AbortController` |
| Manejo de errores de red y HTTP | ✅ | Bloque `try...catch`, validación de `response.ok` y mensaje en pantalla |
| Actualización dinámica del DOM | ✅ | Se reemplaza solo `#api-resultados`; no hay recarga ni `location.reload()` |
| Construcción de tarjetas desde el JSON | ✅ | `crearTarjeta()` crea los nodos con `document.createElement()` |

## Endpoint

`GET api/clases.php`

| Parámetro | Tipo | Descripción |
|---|---|---|
| `q` | texto (máx. 60) | Busca en nombre de clase, instructor, categoría y sede |
| `categoria` | texto (máx. 40) | Filtra por el nombre exacto de una categoría existente |

Ejemplo:

```
GET api/clases.php?q=yoga&categoria=Yoga
```

Respuesta `200 OK`:

```json
{
  "status": "success",
  "total": 1,
  "query": "yoga",
  "categoria": "Yoga",
  "data": [
    {
      "id": 3,
      "nombre": "Yoga Flow",
      "categoria": "Yoga",
      "instructor": "Lucía Gómez",
      "sede": "Forja Centro",
      "dia_semana": "Viernes",
      "hora": "08:00",
      "cupo": 18
    }
  ]
}
```

Códigos de estado:

| Código | Situación |
|---|---|
| 200 | Consulta correcta, incluso si el arreglo `data` queda vacío |
| 400 | `q` o `categoria` superan el largo permitido, o la categoría no existe |
| 405 | Se usa un método distinto de GET (incluye cabecera `Allow: GET`) |
| 500 | Error de conexión o de consulta a la base de datos |

La búsqueda usa `LIKE` con comodines y una sola consulta con `INNER JOIN` a `categorias_clase`, `usuarios` y `sedes`. El resultado se ordena por día de la semana y hora, y se limita a 50 registros.

## Frontend

El HTML de la sección se agregó en `clases.php`:

```html
<section id="buscador-clases" data-api-clases data-endpoint="api/clases.php">
    ...
    <input type="search" id="api-busqueda">
    <select id="api-categoria">...</select>
    <p id="api-estado" role="status" aria-live="polite"></p>
    <div id="api-resultados" class="cards-grid row g-3" aria-live="polite"></div>
</section>
<script src="js/clases-api.js"></script>
```

`js/clases-api.js`:

- Espera `DOMContentLoaded` y carga las clases al abrir la página.
- Aplica un retraso de 300 ms al escribir para no lanzar una petición por cada tecla.
- Cancela la petición anterior con `AbortController` si el usuario sigue escribiendo.
- Muestra “Buscando clases…”, “Mostrando N clases.”, “Sin resultados.” o un mensaje de error de conexión.
- Usa `textContent` para insertar los datos de la base y evitar XSS.
- No usa `innerHTML` con datos del servidor ni scripts en línea, por lo que respeta la CSP del sitio.

## Cómo probarlo

1. Habilitar `extension=pdo_mysql` en `php.ini` (en XAMPP y Laragon ya viene activa).
2. Copiar `.env.example` a `.env` y ajustar `DB_PORT` si el motor no usa el 3306.
3. Importar `schema.sql` y `consultas.sql` de [`Trabajo Practico 6`](../Trabajo%20Practico%206/).
4. Ejecutar el sitio con `php -S localhost:8000 router.php` (o con XAMPP/Laragon).
5. Abrir `http://localhost:8000/clases.php` y usar el buscador “Búsqueda en tiempo real” o la API directamente:

```bash
curl "http://localhost:8000/api/clases.php"
curl "http://localhost:8000/api/clases.php?q=yoga"
curl "http://localhost:8000/api/clases.php?categoria=CrossFit"
curl -i "http://localhost:8000/api/clases.php?q=zzzz"
```

## Pruebas realizadas en local

| Prueba | Resultado |
|---|---|
| GET sin filtros | 200 con las 3 clases cargadas en la base |
| `?q=yoga` | 200 con 1 resultado (`Yoga Flow`) |
| `?categoria=Yoga` | 200 con 1 resultado |
| `?q=Lucia` (sin tilde) | 200 con 2 resultados por la colación sin distinción de acentos |
| `?q=zzzz` | 200 con `data: []` |
| Categoría inexistente | 400 con mensaje JSON |
| `q` de 61 caracteres | 400 con mensaje JSON |
| POST al endpoint | 405 con cabecera `Allow: GET` |
| Escritura en el buscador | La tarjeta se actualiza sin recargar la página; la consola no muestra errores |

## Git

Commit sugerido para esta entrega:

```bash
git add api js/clases-api.js clases.php "Trabajo Practico 9" README.md
git commit -m "feat: implementa fetch api y endpoint json para TP9"
```

## Nota sobre nombres de archivos

La consigna sugiere `api/buscar_productos.php` y `js/app.js`. En el proyecto (sitio de gimnasio) el endpoint es [`api/clases.php`](../api/clases.php) y el script del buscador es [`js/clases-api.js`](../js/clases-api.js). La funcionalidad es la misma: endpoint JSON con PDO preparado y consumo con `fetch()` + `async/await`.
