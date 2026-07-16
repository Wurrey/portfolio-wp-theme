<?php
/**
 * Tarjeta de actividad — reutilizada en Inicio y en Proyectos/Actividades.
 *
 * @package MarcBorrell
 */
?>
<article class="card-actividad" data-animar>
	<a href="<?php the_permalink(); ?>" class="card-actividad__link">
		<div class="card-actividad__media">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'actividad-card', array( 'class' => 'card-actividad__img', 'alt' => esc_attr( get_the_title() ) ) );
			}
			?>
		</div>
		<h3 class="card-actividad__title"><?php the_title(); ?></h3>
		<?php marcborrell_tech_pills( get_the_ID() ); ?>
	</a>
</article>
