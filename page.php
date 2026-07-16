<?php
/**
 * page.php — Plantilla de página genérica (respaldo).
 * Se usa para cualquier Página que no tenga una plantilla específica asignada.
 *
 * @package MarcBorrell
 */

get_header();
?>

<article class="container page-generica">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<h1><?php the_title(); ?></h1>
		<div class="page-generica__contenido">
			<?php the_content(); ?>
		</div>
		<?php
	endwhile;
	?>
</article>

<?php
get_footer();
