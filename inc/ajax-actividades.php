<?php
/**
 * Endpoint AJAX: filtro por tecnología + "Cargar más" en Proyectos/Actividades.
 *
 * Se consulta server-side (no solo ocultando tarjetas con CSS) para que el
 * filtro funcione sobre las 29 actividades reales, no solo sobre el lote
 * que ya esté cargado en pantalla.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MARCBORRELL_ACTIVIDADES_POR_PAGINA', 9 );

/**
 * Iguala el número de actividades por página en la consulta principal
 * (archive-actividad.php y taxonomy-tecnologia.php) con el que usa el
 * AJAX de "Cargar más" — si no, la segunda página podría repetir o
 * saltarse actividades.
 */
function marcborrell_set_actividades_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive( 'actividad' ) || is_tax( 'tecnologia' ) ) ) {
		$query->set( 'posts_per_page', MARCBORRELL_ACTIVIDADES_POR_PAGINA );

		$orden = isset( $_GET['orden'] ) && 'asc' === $_GET['orden'] ? 'ASC' : 'DESC'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$query->set( 'orderby', 'date' );
		$query->set( 'order', $orden );
	}
}
add_action( 'pre_get_posts', 'marcborrell_set_actividades_per_page' );

function marcborrell_ajax_load_actividades() {
	check_ajax_referer( 'marcborrell_actividades', 'nonce' );

	$pagina     = isset( $_POST['pagina'] ) ? max( 1, absint( $_POST['pagina'] ) ) : 1;
	$tecnologia = isset( $_POST['tecnologia'] ) ? sanitize_text_field( wp_unslash( $_POST['tecnologia'] ) ) : '';
	$orden      = isset( $_POST['orden'] ) && 'asc' === $_POST['orden'] ? 'ASC' : 'DESC';

	$args = array(
		'post_type'      => 'actividad',
		'posts_per_page' => MARCBORRELL_ACTIVIDADES_POR_PAGINA,
		'paged'          => $pagina,
		'orderby'        => 'date',
		'order'          => $orden,
	);

	if ( ! empty( $tecnologia ) && 'todos' !== $tecnologia ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'tecnologia',
				'field'    => 'slug',
				'terms'    => sanitize_title( $tecnologia ),
			),
		);
	}

	$query = new WP_Query( $args );

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/card-actividad' );
		}
		wp_reset_postdata();
	}
	$html = ob_get_clean();

	wp_send_json_success(
		array(
			'html'    => $html,
			'hasMore' => $pagina < $query->max_num_pages,
		)
	);
}
add_action( 'wp_ajax_marcborrell_load_actividades', 'marcborrell_ajax_load_actividades' );
add_action( 'wp_ajax_nopriv_marcborrell_load_actividades', 'marcborrell_ajax_load_actividades' );
