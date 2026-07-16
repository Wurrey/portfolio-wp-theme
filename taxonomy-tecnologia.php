<?php
/**
 * taxonomy-tecnologia.php — Actividades filtradas por una tecnología.
 *
 * URL automática /tecnologia/{slug}/ (ej. /tecnologia/css/) — generada
 * sola por WordPress en cuanto existe el término, sin crear nada a mano.
 * Esto es lo que permite que cada filtro tenga una URL real, compartible
 * y rastreable por buscadores, en vez de vivir solo detrás de JavaScript.
 *
 * @package MarcBorrell
 */

get_header();

$termino = get_queried_object();
?>

<section class="container proyectos-header">
	<h1>
		<?php
		/* translators: %s: nombre de la tecnología, ej. "CSS" */
		printf( esc_html__( 'Proyectos / Actividades — %s', 'marcborrell' ), esc_html( $termino->name ) );
		?>
	</h1>
</section>

<?php get_template_part( 'template-parts/actividades-listing' ); ?>

<?php
get_footer();
