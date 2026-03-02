---
name: spanish-proofread-and-copywriter
description: Corrige y normaliza textos visibles de la app en castellano profesional, natural y consistente, sin tocar lógica de negocio.
license: MIT
---

# Skill: $spanish-proofread-and-copywriter
## Objetivo
Garantizar que todos los textos visibles del proyecto estén redactados en español correcto, profesional y natural, sin errores ortográficos, sin tono robótico y sin mensajes internos de desarrollo.

## Alcance
Aplicar esta skill sobre textos de:
- Vistas Blade (`resources/views/**/*.blade.php`)
- Layouts
- Componentes Livewire (texto visible en `.php` y `.blade.php`)
- Home, calculadora, páginas SEO y páginas legales
- Disclaimers, CTA y microcopy

## Reglas obligatorias
### 1) Ortografía y gramática
- Corregir tildes, puntuación y mayúsculas/minúsculas.
- Corregir `n` por `ñ` cuando corresponda.
- Eliminar errores frecuentes (`simulacion` -> `simulación`).

### 2) Estilo editorial
- Mantener un tono claro, conciso y profesional.
- Evitar repeticiones y frases rígidas.
- Unificar tono y estilo en toda la web.

### 3) Eliminar copy técnico
- Reescribir o eliminar textos de prototipo/MVP o lenguaje interno de desarrollo.
- No mostrar referencias técnicas internas (Livewire, Flux, motor de dominio) salvo que sean necesarias para el usuario final.

### 4) Coherencia terminológica
- Usar siempre `IRPF`.
- Usar `Comunidad Autónoma` / `CCAA` de forma consistente.
- Respetar nombres oficiales de regiones (`Cataluña`, `Castilla y León`, etc.).
- Formato de moneda recomendado: `15.000 €`.

### 5) Restricción crítica
- No cambiar lógica, rutas, validaciones ni estructuras de datos.
- Solo modificar texto visible.
- Mantener intactas directivas Blade, variables y flujo de componentes.

## Flujo de trabajo recomendado
1. Detectar archivos con texto visible.
2. Corregir ortografía y estilo.
3. Sustituir textos técnicos por copy orientado a usuario.
4. Revisar coherencia global de terminología.
5. Entregar resumen con:
- archivos modificados
- cambios de copy clave (antes/después)
- confirmación de no afectar lógica

## Prompt sugerido
`Usa $spanish-proofread-and-copywriter y corrige todo el copy visible del proyecto sin tocar lógica.`
