<?php
/**
 * Carga de estilos, scripts y fuentes del tema.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marcborrell_enqueue_assets() {
	// Preconnect a Google Fonts para acelerar la carga.
	wp_enqueue_style(
		'marcborrell-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap',
		array(),
		null
	);

	// Bootstrap Icons — únicamente la fuente de iconos (estilo outline cerrado en Figma),
	// no se usa el framework Bootstrap completo en esta web.
	wp_enqueue_style(
		'bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
		array(),
		'1.13.1'
	);

	// Hoja de estilos principal del tema.
	wp_enqueue_style(
		'marcborrell-style',
		get_stylesheet_uri(),
		array( 'marcborrell-fonts', 'bootstrap-icons' ),
		MARCBORRELL_VERSION
	);

	// Estilos de componentes (header, footer, cards, hero, formularios...).
	wp_enqueue_style(
		'marcborrell-components',
		get_template_directory_uri() . '/assets/css/components.css',
		array( 'marcborrell-style' ),
		MARCBORRELL_VERSION
	);


	// Estilos de la página de proceso — solo se cargan en esa página.
	if ( is_page_template( 'page-proceso.php' ) ) {
		wp_enqueue_style(
			'marcborrell-proceso',
			get_template_directory_uri() . '/assets/css/proceso.css',
			array( 'marcborrell-components' ),
			MARCBORRELL_VERSION
		);
	}

	// JS principal: menú móvil, filtros de tecnología, "cargar más", animaciones al hacer scroll.
	wp_enqueue_script(
		'marcborrell-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		MARCBORRELL_VERSION,
		true
	);

	// Datos para las llamadas AJAX del filtro de tecnología + "Cargar más".
	wp_localize_script(
		'marcborrell-main',
		'marcborrellData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'marcborrell_actividades' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'marcborrell_enqueue_assets' );

/**
 * Preconnect para los dominios externos de fuentes (rendimiento).
 */
function marcborrell_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'marcborrell_resource_hints', 10, 2 );
