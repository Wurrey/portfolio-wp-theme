<?php
/**
 * Funciones de ayuda reutilizadas en varias plantillas.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Menú de respaldo si todavía no se ha creado el menú "primary" desde
 * Apariencia > Menús. Evita que el header se quede vacío mientras se
 * monta el contenido.
 */
function marcborrell_fallback_menu() {
	echo '<ul class="nav-menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Inicio</a></li>';
	echo '<li><a href="' . esc_url( get_post_type_archive_link( 'actividad' ) ) . '">Proyectos / Actividades</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/sobre-mi/' ) ) . '">Sobre mí</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contacto/' ) ) . '">Contacto</a></li>';
	echo '</ul>';
}

/**
 * Imprime las pills de tecnología de una actividad (multi-categoría).
 * Se usa tanto en las tarjetas (card-actividad.php) como en la página
 * de detalle (single-actividad.php).
 *
 * @param int $post_id ID de la actividad.
 */
function marcborrell_tech_pills( $post_id ) {
	$terms = get_the_terms( $post_id, 'tecnologia' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return;
	}

	echo '<ul class="tech-pills">';
	foreach ( $terms as $term ) {
		echo '<li class="tech-pill">' . esc_html( $term->name ) . '</li>';
	}
	echo '</ul>';
}

/**
 * SVG inline del icono de CodePen.
 * Bootstrap Icons no incluye CodePen — se usa el SVG oficial que Marc descargó.
 * Color heredado del padre via currentColor.
 *
 * @return string HTML del SVG sanitizado.
 */
function marcborrell_codepen_icon() {
	return '<svg width="20" height="20" viewBox="0 0 36 36" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M27.216 19.6005V16.3995L24.825 18L27.216 19.6005ZM29.13 21.3915C29.1298 21.4332 29.1267 21.4747 29.121 21.516L29.1135 21.558L29.097 21.6375L29.082 21.684C29.0745 21.708 29.067 21.7305 29.0565 21.7545L29.0355 21.7995C29.0257 21.8213 29.0152 21.8428 29.004 21.864L28.9755 21.909C28.9413 21.9633 28.901 22.0137 28.8555 22.059L28.8165 22.0965C28.7991 22.1122 28.7811 22.1272 28.7625 22.1415L28.719 22.1745L28.704 22.1865L18.531 28.9695C18.3738 29.0746 18.189 29.1306 18 29.1306C17.811 29.1306 17.6262 29.0746 17.469 28.9695L7.296 22.185L7.281 22.173C7.24673 22.1493 7.21415 22.1232 7.1835 22.095L7.1445 22.0575L7.0965 22.0065L7.065 21.9645C7.02556 21.9133 6.99186 21.858 6.9645 21.7995L6.9435 21.753C6.93409 21.7298 6.92558 21.7063 6.918 21.6825L6.903 21.6375C6.897 21.6105 6.891 21.5835 6.888 21.5565L6.879 21.5145C6.87325 21.4732 6.87024 21.4317 6.87 21.39V14.6085C6.87 14.5665 6.873 14.526 6.879 14.484L6.8865 14.4435L6.903 14.3625L6.918 14.3175C6.95357 14.1972 7.015 14.0861 7.098 13.992L7.1445 13.941L7.1835 13.9035C7.21422 13.8753 7.24679 13.8493 7.281 13.8255L7.296 13.8135L17.469 7.032C17.6262 6.92713 17.811 6.87117 18 6.87117C18.189 6.87117 18.3738 6.92713 18.531 7.032L28.704 13.8135L28.719 13.8255L28.764 13.8585L28.8165 13.9035C28.8315 13.9155 28.842 13.9275 28.8555 13.941C28.9013 13.9861 28.9415 14.0365 28.9755 14.091L29.004 14.136C29.0153 14.1571 29.0258 14.1786 29.0355 14.2005L29.0565 14.2455C29.067 14.2695 29.0745 14.2935 29.082 14.316L29.097 14.3625C29.103 14.3895 29.109 14.4165 29.112 14.4435L29.121 14.484C29.1268 14.5253 29.1298 14.5668 29.13 14.6085V21.3915ZM18 0C8.0595 0 0 8.058 0 18C0 27.9405 8.0595 36 18 36C27.942 36 36 27.942 36 18C36 8.0595 27.942 0 18 0ZM18 15.738L14.6175 18L18 20.265L21.3825 18L18 15.738ZM18.957 21.924V26.3865L26.451 21.3915L23.103 19.152L18.957 21.924ZM9.549 21.39L17.043 26.385V21.924L12.897 19.1505L9.549 21.39ZM26.451 14.61L18.957 9.615V14.076L23.103 16.851L26.451 14.61ZM17.043 14.076V9.615L9.549 14.61L12.897 16.8495L17.043 14.076ZM8.784 16.3995V19.6005L11.175 18L8.784 16.3995Z"/>
	</svg>';
}

/**
 * Lista de redes sociales (footer e Inicio). Centralizada aquí para no
 * repetir la misma lista de enlaces en dos plantillas distintas.
 *
 * @return array<string,array<string,string>>
 */
function marcborrell_social_links() {
	return array(
		'github'    => array(
			'label' => 'GitHub',
			'icon'  => 'bi-github',
			'url'   => 'https://github.com/Wurrey',
		),
		'linkedin'  => array(
			'label' => 'LinkedIn',
			'icon'  => 'bi-linkedin',
			'url'   => 'https://www.linkedin.com/in/marc-borrell-capdevila-2b3539101',
		),
		'instagram' => array(
			'label' => 'Instagram',
			'icon'  => 'bi-instagram',
			'url'   => 'https://www.instagram.com/marcborrellcapdevila/',
		),
		'codepen'   => array(
			'label' => 'CodePen',
			'icon'  => 'bi-code-slash',
			'url'   => 'https://codepen.io/Wurrey',
		),
	);
}
