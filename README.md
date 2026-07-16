# portfolio-wp-theme

Tema WordPress custom para portfolio personal — CPT, taxonomía, filtrado AJAX y metaboxes a medida.

Construido desde cero como proyecto final de un bootcamp de desarrollo web, sin frameworks de terceros ni page builders. En producción en [wurrey.com](https://wurrey.com).

## Qué incluye

- **Custom Post Type "Actividad"** + taxonomía no jerárquica "Tecnología", para catalogar proyectos por stack (HTML, CSS, JavaScript, Bootstrap, WordPress, Figma).
- **Filtrado AJAX** por tecnología con `tax_query` y actualización de la URL vía `pushState` — cada filtro es una URL real y compartible, sin recargar la página.
- **Paginación "Cargar más"** vía AJAX.
- **Metaboxes a medida**:
  - *Evolución y versiones*: pasos del proceso de cada actividad, con imagen y texto alternados.
  - *Ficha — conceptos clave*: resumen de aprendizaje + cita destacada en la barra lateral.
- **Formulario de contacto** funcional vía `wp_mail()`, con destinatario configurable desde el Customizer (independiente del `admin_email` de WordPress).
- **JS vanilla** (sin librerías): preloader, barra de progreso de scroll, botón "volver arriba", animaciones con `IntersectionObserver` (incluye tarjetas cargadas por AJAX), modal de imagen, validación de formulario.
- **SEO/AEO**: integrado con Rank Math (schema `Person`/`Organization` con `sameAs`, Article, WebSite), enlaces `rel="me"` a redes sociales.

## Stack

PHP · MySQL · JavaScript vanilla · WordPress (sin frameworks CSS ni page builders)

## Estructura

```
inc/
  post-types.php          → registro del CPT "actividad"
  taxonomies.php          → taxonomía "tecnologia"
  ajax-actividades.php    → filtrado y paginación AJAX
  metabox-evolucion.php   → metabox "Evolución y versiones"
  metabox-ficha.php       → metabox "Ficha — conceptos clave"
  contact-form.php        → procesamiento del formulario de contacto
  customizer.php          → opciones expuestas en el Customizer
  theme-setup.php         → soporte de tema, menús, imágenes destacadas
  enqueue.php             → carga de estilos y scripts
  template-helpers.php    → funciones auxiliares reutilizables
  seo-actividades.php     → ajustes SEO específicos del CPT
template-parts/           → partials reutilizables (listado, tarjetas)
assets/
  css/                    → estilos por componente
  js/main.js              → toda la interactividad del front
```

## Uso

Pensado para adaptarse a cualquier portfolio personal, no solo al mío. Para ponerlo en marcha:

1. Sube la carpeta a `/wp-content/themes/` y actívalo desde Apariencia → Temas.
2. Al activarlo se crean automáticamente los términos de tecnología (editables desde el escritorio).
3. En Ajustes → Enlaces permanentes, elige "Nombre de la entrada" y guarda — necesario para que las URLs de actividades y filtros funcionen.
4. Crea las páginas "Sobre mí" y "Contacto" con sus plantillas correspondientes (Atributos de página → Plantilla).
5. Configura el menú principal y el email de contacto desde el Customizer.

## Contexto del proyecto

Este tema es la pieza central de mi proyecto final de bootcamp. La documentación completa del proceso — decisiones de diseño, arquitectura, retos técnicos — está en la [Memoria](https://wurrey.com/memoria/), y la presentación para el tribunal en la [Exposición](https://wurrey.com/exposicion/).

## Autor

**Marc Borrell** — de administración/contabilidad a desarrollo frontend.

- Portfolio: [wurrey.com](https://wurrey.com)
- GitHub: [@Wurrey](https://github.com/Wurrey)
- LinkedIn: [Marc Borrell Capdevila](https://www.linkedin.com/in/marc-borrell-capdevila-2b3539101)
- CodePen: [@Wurrey](https://codepen.io/Wurrey)
