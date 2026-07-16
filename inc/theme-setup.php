<?php
/**
 * Theme setup: soporte de funcionalidades, menús, tamaños de imagen.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configuración base del tema.
 */
function marcborrell_setup() {
	// Traducción.
	load_theme_textdomain( 'marcborrell', get_template_directory() . '/languages' );

	// <title> generado automáticamente por WordPress.
	add_theme_support( 'title-tag' );

	// Imagen destacada (la usamos como imagen de cada actividad).
	add_theme_support( 'post-thumbnails' );

	// Salida HTML5 para formularios de búsqueda, comentarios, galerías, etc.
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	// Imagen destacada personalizable desde el Customizer (logo, si se necesita).
	add_theme_support( 'custom-logo' );

	// Menú principal de navegación — el del header con Inicio/Proyectos/Sobre mí/Contacto.
	register_nav_menus(
		array(
			'primary' => __( 'Menú principal', 'marcborrell' ),
			'footer'  => __( 'Menú del footer', 'marcborrell' ),
		)
	);

	// Tamaño de imagen para las tarjetas de actividad (ratio ~16:9, coincide con Figma).
	add_image_size( 'actividad-card', 600, 360, true );
	add_image_size( 'actividad-hero', 1200, 600, true );
}
add_action( 'after_setup_theme', 'marcborrell_setup' );

/**
 * Anchura de contenido por defecto (usada por WP para incrustar oEmbeds, etc).
 */
function marcborrell_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'marcborrell_content_width', 1392 );
}
add_action( 'after_setup_theme', 'marcborrell_content_width', 0 );
