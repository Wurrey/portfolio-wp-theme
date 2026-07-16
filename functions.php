<?php
/**
 * marcborrell functions and definitions
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No acceso directo.
}

define( 'MARCBORRELL_VERSION', '1.0.0' );

/**
 * Carga el resto de archivos del tema.
 * Cada pieza vive en su propio archivo dentro de /inc para que el tema
 * sea fácil de mantener: setup, menús, post types, taxonomías y assets
 * no se mezclan en un único functions.php gigante.
 */
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/template-helpers.php';
require_once get_template_directory() . '/inc/ajax-actividades.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/metabox-evolucion.php';
require_once get_template_directory() . '/inc/metabox-ficha.php';
// inc/seo.php eliminado — sustituido por el plugin Rank Math.
require_once get_template_directory() . '/inc/seo-actividades.php';
