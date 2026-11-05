# Trabajo Práctico 5: Formularios y seguridad web

Volver al [índice](../README.md)

La consigna pide que todo el desarrollo esté en una carpeta llamada exactamente `clase5`. Por eso el código está en [`clase5/`](../clase5/) y esta carpeta documenta cómo se cumple cada requisito.

| Requisito | Estado | Evidencia |
|---|---|---|
| Carpeta `clase5` con todo el desarrollo | ✅ | [`clase5/`](../clase5/) |
| Formulario POST (contacto) | ✅ | [`clase5/index.php`](../clase5/index.php), sección `#contacto` |
| Formulario GET (buscador y filtro de clases) | ✅ | [`clase5/index.php`](../clase5/index.php), sección `#clases` |
| Sanitización (`htmlspecialchars`, `trim`, `filter_input`) | ✅ | [`clase5/includes/functions.php`](../clase5/includes/functions.php) |
| Validación en servidor (`empty`, `isset`, email) | ✅ | `validar_contacto()` en el mismo archivo |
| Mensajes de éxito y error | ✅ | Cajas verde y roja en la vista |
| Persistencia de campos tras un error | ✅ | `value="..."` escapado en cada campo |
| Capturas en el README | ✅ | [README raíz, Clase 5](../README.md#clase-5--procesamiento-de-formularios-y-seguridad-web-post--get) y [`clase5/screenshots/`](../clase5/screenshots/) |
| Actualizado en `main` | ✅ | Integrado en `main` |
| Demostración en vivo | ⏳ | `php -S localhost:8000 -t clase5` |
