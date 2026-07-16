# Tema "Marc Borrell" — guía de puesta en marcha

## 1. Subir el tema
Sube toda la carpeta `marcborrell/` (tal cual, sin descomprimir nada dentro) a:
`/wp-content/themes/` vía FileZilla o WP File Manager.

## 2. Activarlo
Escritorio de WordPress → Apariencia → Temas → Activar "Marc Borrell — Portfolio".

Al activarlo se crean automáticamente los 6 términos de tecnología
(HTML, CSS, JavaScript, Bootstrap, Figma, WordPress) — no hace falta
crearlos a mano.

## 3. Permalinks
Ajustes → Enlaces permanentes → elegir **"Nombre de la entrada"** y guardar.
Sin esto, las URLs de las actividades (`/actividades/nombre-actividad/`)
no funcionarán correctamente.

## 4. Crear las 2 páginas (Inicio y Proyectos/Actividades NO hacen falta)
La portada (Inicio) la genera `front-page.php`, y el listado de
actividades lo genera automáticamente WordPress en cuanto el tema está
activo, gracias al registro del Custom Post Type:

- **Todas las actividades**: `tudominio.com/actividades/`
  (plantilla `archive-actividad.php`)
- **Filtradas por tecnología**: `tudominio.com/tecnologia/css/`,
  `tudominio.com/tecnologia/html/`, etc. — una URL real y compartible
  por cada tecnología (plantilla `taxonomy-tecnologia.php`)

No hay que crear ninguna Página para esto. Al pulsar un filtro en el
sitio, el cambio ocurre en la misma página (sin recargar, tal y como
se decidió) pero la URL del navegador también se actualiza por debajo,
así que cualquier filtro se puede compartir como enlace directo.

Sí tienes que crear estas 2 páginas desde Páginas → Añadir nueva,
y en el panel lateral derecho "Atributos de página" → Plantilla,
asignar la plantilla indicada:

| Página       | Slug (URL)  | Plantilla a asignar       |
|--------------|-------------|----------------------------|
| Sobre mí     | `sobre-mi`  | Sobre mí                   |
| Contacto     | `contacto`  | Contacto                   |

Importante: el slug debe ser exactamente `sobre-mi` y `contacto`
(WordPress los genera solos a partir del título si los títulos son
"Sobre mí" y "Contacto" — pero conviene revisarlo en "Editar enlace
permanente" antes de publicar).

## 5. Crear el menú
Apariencia → Menús → crear un menú nuevo. Para "Proyectos /
Actividades" verás un panel "Actividades" en la columna izquierda
(activa "Ver todo" si no aparece) con un enlace de Archivo ya listo
para añadir — eso enlaza directamente a `/actividades/`. Si no
aparece, añade un Enlace personalizado con la URL `/actividades/` y el
texto "Proyectos / Actividades".

En total el menú debe llevar: Inicio (enlace personalizado a `/`),
Proyectos / Actividades, Sobre mí, Contacto.
Asignarlo a la ubicación **"Menú principal"**.

## 6. Crear las actividades
Aparecerá un nuevo apartado "Actividades" en el menú lateral del
escritorio. Cada actividad se crea como una entrada normal: título,
contenido (descripción), imagen destacada (la imagen de la tarjeta) y,
en el panel lateral, las "Tecnologías" correspondientes (puedes marcar
varias a la vez — por eso las actividades 1 y 2 podrán llevar a la vez
HTML y CSS, por ejemplo).

## 7. Pendiente para la fase de contenido (no estructura)
- **CodePen en el footer**: el icono usa de momento la clase
  `bi-code-slash` de Bootstrap Icons como placeholder, porque Bootstrap
  Icons no tiene un logo de CodePen real (lo comprobamos en Figma). Si
  quieres usar exactamente el SVG que localizaste para el prototipo,
  habrá que sustituir ese `<i class="bi bi-code-slash">` en `footer.php`
  por el `<svg>` real.
- **URLs de las redes sociales**: ahora mismo apuntan a marcadores
  genéricos (`github.com/`, `linkedin.com/`, etc.) en
  `inc/template-helpers.php` → función `marcborrell_social_links()`.
  Hay que poner tus URLs reales ahí.
- **"Evolución y versiones" de cada actividad**: la estructura ya
  alterna imagen izquierda/derecha automáticamente, pero los pasos se
  rellenan por código (meta `actividad_evolucion`) — en la fase de
  contenido lo más cómodo será que te prepare un metabox sencillo en
  el editor para que los rellenes tú mismo sin tocar código.
- **Imagen del hero de Inicio**: usa la imagen destacada de la propia
  portada. Como no hay una "página" de Inicio en el escritorio (la
  genera `front-page.php` automáticamente), esa imagen destacada se
  asignará desde Ajustes o se cambiará a una ruta fija — lo resolvemos
  en la fase de contenido.

## 8. Lo que SÍ funciona ya, en cuanto subas el tema
- Estructura completa de las 5 páginas y navegación.
- Menú hamburguesa en móvil.
- Custom Post Type "Actividad" con su propia URL y campo de
  Tecnologías (multi-selección).
- Filtro de tecnología en Proyectos/Actividades — funciona de verdad
  contra la base de datos (no solo oculta tarjetas con CSS), y cada
  filtro tiene su propia URL real y compartible (`/tecnologia/css/`),
  generada automáticamente por la jerarquía de plantillas de WordPress.
- Botón "Cargar más" con paginación real vía AJAX.
- Formulario de Contacto funcional (envía un email a la cuenta de
  administrador de WordPress).
- Tokens de diseño (colores, tipografías) ya cargados en `style.css`,
  fuentes Fraunces + Inter cargadas vía Google Fonts, e iconos
  Bootstrap Icons cargados vía CDN.

Lo que falta es la maquetación visual fina (CSS de cada componente
para que coincida pixel a pixel con Figma) y el contenido real de las
29 actividades — el siguiente paso natural.
