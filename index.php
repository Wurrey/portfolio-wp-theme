<?php
/**
 * index.php — Plantilla de respaldo obligatoria.
 *
 * WordPress exige que todo tema tenga este archivo. Las plantillas
 * específicas (front-page.php, archive-actividad.php, single-actividad.php...)
 * tienen prioridad siempre que existan, así que esta solo entra en juego
 * en casos no cubiertos explícitamente.
 *
 * @package MarcBorrell
 */

get_header();
?>

<div class="container">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
			<?php
		endwhile;
	else :
		?>
		<p><?php esc_html_e( 'No se ha encontrado contenido.', 'marcborrell' ); ?></p>
		<?php
	endif;
	?>
</div>

<?php
get_footer();
