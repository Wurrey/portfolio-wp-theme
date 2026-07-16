<?php
/**
 * Taxonomía: Tecnología.
 *
 * No jerárquica (como las etiquetas) para que una actividad pueda
 * pertenecer a varias tecnologías a la vez — es justo el comportamiento
 * "multi-categoría" que se cerró en el diseño (ej. una actividad puede
 * ser HTML + CSS + Bootstrap a la vez).
 *
 * Los términos (HTML, CSS, JavaScript, Bootstrap, Figma, WordPress) se
 * crean una sola vez la primera vez que el tema se activa, para que
 * los filtros de la página de Proyectos siempre tengan las mismas
 * opciones que las pills de "Tecnologías" en Sobre mí.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marcborrell_register_tecnologia_taxonomy() {
	$labels = array(
		'name'          => __( 'Tecnologías', 'marcborrell' ),
		'singular_name' => __( 'Tecnología', 'marcborrell' ),
		'search_items'  => __( 'Buscar tecnologías', 'marcborrell' ),
		'all_items'     => __( 'Todas las tecnologías', 'marcborrell' ),
		'edit_item'     => __( 'Editar tecnología', 'marcborrell' ),
		'add_new_item'  => __( 'Añadir nueva tecnología', 'marcborrell' ),
		'menu_name'     => __( 'Tecnologías', 'marcborrell' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false, // Como las etiquetas: una actividad puede tener varias.
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'tecnologia' ),
	);

	register_taxonomy( 'tecnologia', array( 'actividad' ), $args );
}
add_action( 'init', 'marcborrell_register_tecnologia_taxonomy' );

/**
 * Crea los 6 términos base la primera vez que se activa el tema,
 * para que coincidan exactamente con las pills ya definidas en Figma.
 */
function marcborrell_create_default_tecnologias() {
	$terminos = array( 'HTML', 'CSS', 'JavaScript', 'Bootstrap', 'Figma', 'WordPress' );

	foreach ( $terminos as $termino ) {
		if ( ! term_exists( $termino, 'tecnologia' ) ) {
			wp_insert_term( $termino, 'tecnologia' );
		}
	}
}
add_action( 'after_switch_theme', 'marcborrell_create_default_tecnologias' );
