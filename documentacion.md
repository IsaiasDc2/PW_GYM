# Auditoría de Accesibilidad y Formateo — Forja Gym

## 1. Formateo con Prettier

Se formateó `index.html` e `index.css` con Prettier para unificar indentación, saltos de línea y comillas en todo el proyecto.

```bash
npx prettier --write index.html index.css
```

## 2. Auditoría de Lighthouse (Chrome DevTools → pestaña Accessibility)

Se corrió Lighthouse sobre `index.html` en local. Hallazgos y correcciones aplicadas:

| Falla detectada | Impacto | Corrección aplicada |
|---|---|---|
| Botones (`<button>`) sin atributo `type` | Riesgo de comportamiento inesperado como submit dentro de formularios | Se agregó `type="button"` a los 27 botones del sitio |
| Campos de formulario (`input`, `select`, `textarea`) sin `<label>` asociado | Lectores de pantalla no pueden anunciar qué representa cada campo | Se asociaron los 6 campos del formulario de contacto (Nombre, Apellido, Email, Teléfono, Sede de interés, Mensaje) mediante `id` + `for`, y se agregó `name` a cada uno |
| Íconos sociales del footer (IG, FB, YT, TW) implementados como `<div>` sin rol interactivo | No son accesibles por teclado ni anunciados como enlaces por lectores de pantalla | Se convirtieron a elementos `<a href="#">` con `aria-label` descriptivo ("Instagram", "Facebook", "YouTube", "Twitter") |
| Cinta de texto animada (marquee) repite contenido decorativo | Lectores de pantalla leen el texto duplicado sin aportar información nueva | Se agregó `aria-hidden="true"` al contenedor del marquee |
| Sin forma de saltar la navegación repetida (header fijo) | Usuarios de teclado deben tabular por todo el menú en cada página | Se agregó un "skip link" (`Saltar al contenido principal`) visible al enfocar con teclado |
| Falta `<meta name="description">` | Afecta SEO y la vista previa al compartir el link | Se agregó una meta description con el resumen del sitio |

## 3. Contraste de color

Se verificaron manualmente los ratios de contraste de la paleta contra el fondo negro (`#080808`):

| Combinación | Ratio | Mínimo WCAG AA | Resultado |
|---|---|---|---|
| Texto secundario `--muted` (#888888) sobre negro | 5.65:1 | 4.5:1 | ✅ Cumple |
| Texto `--text-dim` (#AAAAAA) sobre negro | 8.62:1 | 4.5:1 | ✅ Cumple |
| Texto negro sobre botones verde ácido (`--acid`) | 16.94:1 | 4.5:1 | ✅ Cumple |

No fue necesario modificar la paleta de colores original.

## 4. Estado final

- Todas las etiquetas HTML quedaron correctamente balanceadas (validado con conteo de apertura/cierre).
- El archivo pasa el formateo de Prettier sin errores.
- Los 6 hallazgos de accesibilidad detectados fueron corregidos directamente en `index.html`.
