<?php
/**
 * archive-actividad.php — Listado de TODAS las actividades.
 *
 * WordPress genera esta URL automáticamente en /actividades/ en cuanto
 * el tema está activo (gracias a 'has_archive' => 'actividades' en el
 * registro del CPT) — no hace falta crear ninguna Página para ella.
 *
 * @package MarcBorrell
 */

get_header();
?>

<section class="container proyectos-header">
	<h1><?php esc_html_e( 'Proyectos / Actividades', 'marcborrell' ); ?></h1>
	<p class="text-muted">
		<?php esc_html_e( 'Todas las actividades del curso, filtrables por tecnología.', 'marcborrell' ); ?>
	</p>
</section>

<?php get_template_part( 'template-parts/actividades-listing' ); ?>

<?php
get_footer();
