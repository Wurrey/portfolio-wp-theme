<?php
/**
 * 404.php — Página no encontrada.
 *
 * @package MarcBorrell
 */

get_header();
?>

<section class="container pagina-404">
	<p class="pagina-404__codigo">404</p>
	<h1><?php esc_html_e( 'Página no encontrada', 'marcborrell' ); ?></h1>
	<p><?php esc_html_e( 'El contenido que buscas no existe o se ha movido.', 'marcborrell' ); ?></p>
	<div class="pagina-404__acciones">
		<a class="btn-ver-todo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( '← Volver al inicio', 'marcborrell' ); ?>
		</a>
		<a class="pagina-404__link-secundario" href="<?php echo esc_url( get_post_type_archive_link( 'actividad' ) ); ?>">
			<?php esc_html_e( 'Ver Proyectos / Actividades', 'marcborrell' ); ?>
		</a>
	</div>
</section>

<?php
get_footer();
