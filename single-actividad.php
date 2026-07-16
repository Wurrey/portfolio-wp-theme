<?php
/**
 * single-actividad.php — Plantilla de detalle de una actividad.
 *
 * Layout: una columna principal (descripción + "Evolución y versiones")
 * junto a una columna lateral sticky ("Conceptos clave"). Las dos viven
 * dentro del mismo contenedor grid para que el sticky tenga recorrido
 * real mientras se lee todo el contenido, no solo la descripción.
 *
 * @package MarcBorrell
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article class="actividad-single">

		<header class="actividad-single__hero">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="actividad-single__hero-media">
					<?php
					the_post_thumbnail(
						'actividad-hero',
						array(
							'class' => 'actividad-single__hero-img',
							'alt'   => esc_attr( get_the_title() ),
						)
					);
					?>
				</div>
			<?php endif; ?>
			<div class="container">
				<h1><?php the_title(); ?></h1>
				<?php marcborrell_tech_pills( get_the_ID() ); ?>
			</div>
		</header>

		<div class="container actividad-single__body">

			<div class="actividad-single__principal">

				<div class="actividad-single__descripcion">
					<?php the_content(); ?>
				</div>

				<?php
				// Pasos de "Evolución y versiones". Se leen de un meta repetible
				// 'actividad_evolucion' (array de {imagen_id, titulo, texto}).
				$pasos = get_post_meta( get_the_ID(), 'actividad_evolucion', true );
				if ( ! empty( $pasos ) && is_array( $pasos ) ) :
					?>
					<section class="actividad-evolucion">
						<h2><?php esc_html_e( 'Evolución y versiones', 'marcborrell' ); ?></h2>

						<ol class="actividad-evolucion__lista">
							<?php foreach ( $pasos as $indice => $paso ) : ?>
								<li class="actividad-evolucion__paso <?php echo 0 === $indice % 2 ? 'is-imagen-derecha' : 'is-imagen-izquierda'; ?>">
									<?php if ( ! empty( $paso['imagen_id'] ) ) : ?>
										<div class="actividad-evolucion__media">
											<?php if ( is_numeric( $paso['imagen_id'] ) ) : ?>
												<?php
										echo wp_get_attachment_image(
											(int) $paso['imagen_id'],
											'large',
											false,
											array( 'alt' => esc_attr( $paso['titulo'] ?? get_the_title() ) )
										);
										?>
											<?php else : ?>
												<img src="<?php echo esc_url( $paso['imagen_id'] ); ?>" alt="<?php echo esc_attr( $paso['titulo'] ?? '' ); ?>">
											<?php endif; ?>
										</div>
									<?php endif; ?>
									<div class="actividad-evolucion__texto">
										<h3><?php echo esc_html( $paso['titulo'] ?? '' ); ?></h3>
										<p><?php echo esc_html( $paso['texto'] ?? '' ); ?></p>
									</div>
								</li>
							<?php endforeach; ?>
						</ol>
					</section>
				<?php endif; ?>

			</div>

			<?php
			$resumen = get_post_meta( get_the_ID(), 'actividad_ficha_resumen', true );
			$cita    = get_post_meta( get_the_ID(), 'actividad_ficha_cita', true );
			if ( ! empty( $resumen ) || ! empty( $cita ) ) :
				?>
				<aside class="actividad-single__ficha">
					<h2><?php esc_html_e( 'Conceptos clave', 'marcborrell' ); ?></h2>
					<?php if ( ! empty( $resumen ) ) : ?>
						<p class="ficha-resumen"><?php echo esc_html( $resumen ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $cita ) ) : ?>
						<blockquote class="ficha-cita"><?php echo esc_html( $cita ); ?></blockquote>
					<?php endif; ?>
				</aside>
			<?php endif; ?>

		</div>

		<nav class="actividad-nav container" aria-label="<?php esc_attr_e( 'Navegación entre actividades', 'marcborrell' ); ?>">
			<a class="actividad-nav__volver" href="<?php echo esc_url( get_post_type_archive_link( 'actividad' ) ); ?>">
				<i class="bi bi-grid" aria-hidden="true"></i>
				<?php esc_html_e( 'Volver a Proyectos / Actividades', 'marcborrell' ); ?>
			</a>

			<div class="actividad-nav__prev-next">
				<?php
				$anterior  = get_previous_post( false, '', 'tecnologia' );
				$siguiente = get_next_post( false, '', 'tecnologia' );
				?>
				<?php if ( $anterior ) : ?>
					<a class="actividad-nav__link actividad-nav__link--prev" href="<?php echo esc_url( get_permalink( $anterior ) ); ?>">
						<i class="bi bi-arrow-left" aria-hidden="true"></i>
						<span>
							<small><?php esc_html_e( 'Anterior', 'marcborrell' ); ?></small>
							<?php echo esc_html( get_the_title( $anterior ) ); ?>
						</span>
					</a>
				<?php else : ?>
					<span></span>
				<?php endif; ?>

				<?php if ( $siguiente ) : ?>
					<a class="actividad-nav__link actividad-nav__link--next" href="<?php echo esc_url( get_permalink( $siguiente ) ); ?>">
						<span>
							<small><?php esc_html_e( 'Siguiente', 'marcborrell' ); ?></small>
							<?php echo esc_html( get_the_title( $siguiente ) ); ?>
						</span>
						<i class="bi bi-arrow-right" aria-hidden="true"></i>
					</a>
				<?php endif; ?>
			</div>
		</nav>

	</article>

	<?php
endwhile;

get_footer();
