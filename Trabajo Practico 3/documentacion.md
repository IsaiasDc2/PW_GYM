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

### Pendiente

- Ejecutar Lighthouse en Chrome DevTools (pestaña Lighthouse, categoría Accessibility) sobre cada vista y pegar aquí la captura del puntaje en `screenshots/tp3/`. La auditoría automática no se pudo correr desde el entorno de desarrollo porque no hay navegador instalado.
