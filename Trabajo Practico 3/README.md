# Trabajo Práctico 3: Maquetación HTML5, Bootstrap y GitHub Pages

Volver al [índice](../README.md)

## Contenido de esta carpeta

| Archivo | Contenido |
|---|---|
| [`documentacion.md`](documentacion.md) | Formateo con Prettier y auditoría de accesibilidad (paso 4) |

Las 10 vistas están en la raíz del repositorio, porque GitHub Pages publica desde ahí.

## Pasos de la consigna vs. evidencia

| Paso | Consigna | Estado | Evidencia |
|---|---|---|---|
| 1 | `git init` y estructura `css/`, `js/`, `img/` | ✅ | [`css/`](../css/), [`js/`](../js/), [`img/`](../img/) |
| 2 | Rama `feature/maquetacion` | ✅ | Existe en `origin/feature/maquetacion` |
| 3 | Maquetar las 10 vistas en HTML5 con Bootstrap y estilos propios | ✅ | [`index`](../index.html), [`nosotros`](../nosotros.html), [`planes`](../planes.html), [`clases`](../clases.html), [`instructores`](../instructores.html), [`nutricion`](../nutricion.html), [`progreso`](../progreso.html), [`comunidad`](../comunidad.html), [`sedes`](../sedes.html), [`contacto`](../contacto.html). Usan [`bootstrap.min.css`](../css/bootstrap.min.css) y [`style.css`](../css/style.css) |
| 4 | Prettier + auditoría Lighthouse + documentar en `.md` | ⚠️ Parcial | Prettier aplicado y correcciones documentadas en [`documentacion.md`](documentacion.md). Falta la captura de Lighthouse |
| 5 | `git push origin feature/maquetacion` y Pull Request a `main` | ✅ | PR #4 |
| 6 | Aprobar y fusionar el PR | ✅ | Commit de merge `90a1fae` |
| 7 | Desplegar en GitHub Pages | ✅ | https://isaiasdc2.github.io/PW_GYM/ |

## Pendiente (hay que hacerlo en el navegador)

- Correr Lighthouse (Chrome DevTools → Lighthouse → Accessibility) y guardar las capturas en una carpeta `capturas/` de esta carpeta. Después enlazarlas en `documentacion.md`.
- Subir las 10 vistas nuevas con una rama y un PR para que GitHub Pages las publique.
