# Formateo y Accesibilidad: Forja Gym (TP 3)

## 1. Vistas maquetadas

Las 10 vistas HTML5 comparten `css/bootstrap.min.css` (grillas responsive) y `css/style.css` (estilos propios del tema oscuro).

| Vista | Archivo |
|---|---|
| Inicio | `index.html` |
| Nosotros | `nosotros.html` |
| Planes y Precios | `planes.html` |
| Clases y Horarios | `clases.html` |
| Instructores | `instructores.html` |
| Nutrición y Hábitos | `nutricion.html` |
| Progreso y Tecnología | `progreso.html` |
| Comunidad | `comunidad.html` |
| Sedes | `sedes.html` |
| Contacto | `contacto.html` |

## 2. Formateo con Prettier

```bash
npx prettier --print-width 120 --write "*.html" css/style.css js/main.js
```

## 3. Auditoría de accesibilidad

Medidas de accesibilidad aplicadas en las 10 vistas (los puntos que Lighthouse revisa en la categoría Accessibility):

| Punto | Corrección aplicada |
|---|---|
| Idioma de la página | `<html lang="es">` |
| Título y descripción | `<title>` propio por vista y `<meta name="description">` |
| Saltar la navegación repetida | Skip link "Saltar al contenido principal" visible al enfocar con teclado |
| Navegación | `aria-label` en cada `<nav>` y `aria-current="page"` con clase `active` en la vista actual |
| Botón de menú móvil | `type="button"`, `aria-label` y `aria-expanded` actualizado desde `js/main.js` |
| Formulario de contacto | Cada campo tiene `<label for>` + `id` + `name` y `autocomplete` |
| Enlaces sociales | `aria-label` descriptivo (Instagram, Facebook, WhatsApp) |
| Foco visible | `outline` en enlaces, botones y campos |
| Jerarquía de títulos | Un solo `<h1>` por vista, seguido de `<h2>` y `<h3>` |

### Contraste (fondo `#080808`)

| Combinación | Ratio | Mínimo WCAG AA | Resultado |
|---|---|---|---|
| `--muted` (#888) sobre negro | 5.65:1 | 4.5:1 | Cumple |
| `--text-dim` (#AAA) sobre negro | 8.62:1 | 4.5:1 | Cumple |
| Texto negro sobre `--acid` | 16.94:1 | 4.5:1 | Cumple |

### Resultados de Lighthouse (categoría Accessibility)

Auditoría en Chrome DevTools (pestaña Lighthouse, solo categoría Accessibility, modo Desktop) sobre el sitio publicado en https://isaiasdc2.github.io/PW_GYM/. Capturas en [`screenshots/tp3/`](screenshots/tp3/).

| Vista | Puntaje | Captura |
|---|---|---|
| Inicio (`index.html`) | 95 | [tp3-01-index.png](screenshots/tp3/tp3-01-index.png) |
| Nosotros (`nosotros.html`) | 95 | [tp3-02-nosotros.png](screenshots/tp3/tp3-02-nosotros.png) |
| Planes y Precios (`planes.html`) | 95 | [tp3-03-planes.png](screenshots/tp3/tp3-03-planes.png) |
| Clases y Horarios (`clases.html`) | 93 | [tp3-04-clases.png](screenshots/tp3/tp3-04-clases.png) |
| Instructores (`instructores.html`) | 94 | [tp3-05-instructores.png](screenshots/tp3/tp3-05-instructores.png) |
| Nutrición y Hábitos (`nutricion.html`) | 94 | [tp3-06-nutricion.png](screenshots/tp3/tp3-06-nutricion.png) |
| Progreso y Tecnología (`progreso.html`) | 94 | [tp3-07-progreso.png](screenshots/tp3/tp3-07-progreso.png) |
| Comunidad (`comunidad.html`) | 94 | [tp3-08-comunidad.png](screenshots/tp3/tp3-08-comunidad.png) |
| Sedes (`sedes.html`) | 94 | [tp3-09-sedes.png](screenshots/tp3/tp3-09-sedes.png) |
| Contacto (`contacto.html`) | 100 | [tp3-10-contacto.png](screenshots/tp3/tp3-10-contacto.png) |

**Promedio:** 94,5 sobre 100.

### Fallas pendientes

- En las 9 vistas con puntaje menor a 100, Lighthouse marca **"Background and foreground colors do not have a sufficient contrast ratio"** en la sección Contrast. Los ratios de la tabla de arriba son de las variables de color principales, pero probablemente haya elementos concretos (por ejemplo, títulos de tarjetas y textos atenuados sobre fondos oscuros) que siguen por debajo de 4.5:1, aunque hay que confirmarlo en el detalle de la auditoría. Hay que abrir el detalle de la auditoría en cada vista, identificar los elementos y corregir sus colores.
- Clases y Horarios (93) tiene además una falla en la sección Navigation.
- Los 10 ítems de "Additional items to manually check" son revisiones manuales de teclado y lectores de pantalla. No descuentan puntaje, pero conviene recorrer el formulario de contacto con Tab para validarlos.
