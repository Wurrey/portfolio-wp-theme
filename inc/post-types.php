<?php
/**
 * Custom Post Type: Actividad.
 *
 * Cada actividad del curso (29 en total) es una entrada de este tipo.
 * El listado vive en archive-actividad.php (todas) y taxonomy-tecnologia.php
 * (filtradas por una tecnología) — son las plantillas que WordPress genera
 * automáticamente según su jerarquía de plantillas, sin necesidad de crear
 * una Página a mano para ello.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marcborrell_register_actividad_cpt() {
	$labels = array(
		'name'                  => __( 'Actividades', 'marcborrell' ),
		'singular_name'         => __( 'Actividad', 'marcborrell' ),
		'add_new_item'          => __( 'Añadir nueva actividad', 'marcborrell' ),
		'edit_item'             => __( 'Editar actividad', 'marcborrell' ),
		'new_item'              => __( 'Nueva actividad', 'marcborrell' ),
		'view_item'              => __( 'Ver actividad', 'marcborrell' ),
		'search_items'           => __( 'Buscar actividades', 'marcborrell' ),
		'not_found'              => __( 'No se encontraron actividades', 'marcborrell' ),
		'all_items'              => __( 'Todas las actividades', 'marcborrell' ),
		'menu_name'              => __( 'Actividades', 'marcborrell' ),
		'featured_image'         => __( 'Imagen de la actividad', 'marcborrell' ),
		'set_featured_image'     => __( 'Establecer imagen de la actividad', 'marcborrell' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'show_in_rest'        => true, // Editor de bloques de Gutenberg.
		'menu_icon'           => 'dashicons-grid-view',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'         => 'actividades', // URL automática /actividades/ — sin crear Página a mano.
		'rewrite'             => array( 'slug' => 'actividades' ),
		'show_in_menu'        => true,
		'menu_position'       => 5,
	);

	register_post_type( 'actividad', $args );
}
add_action( 'init', 'marcborrell_register_actividad_cpt' );
