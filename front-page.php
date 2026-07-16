<?php
/**
 * front-page.php — Página de Inicio.
 *
 * Se activa automáticamente como portada en cuanto en Ajustes > Lectura
 * se elija "Una página estática" (no hace falta crear una Página aparte
 * para Inicio: WordPress usa esta plantilla directamente como portada).
 *
 * @package MarcBorrell
 */

get_header();
?>

<section class="hero-inicio">
	<div class="hero-inicio__media">
		<?php
		$hero_url = get_theme_mod( 'hero_image_url', '' );
		if ( $hero_url ) :
			?>
			<img class="hero-inicio__img"
				 src="<?php echo esc_url( $hero_url ); ?>"
				 alt="<?php esc_attr_e( 'Marc trabajando en su portfolio — escritorio con portátil y código', 'marcborrell' ); ?>">
		<?php endif; ?>
	</div>
	<div class="hero-inicio__overlay"></div>
	<div class="container hero-inicio__content">
		<h1><?php esc_html_e( 'Marc Borrell', 'marcborrell' ); ?></h1>
		<p><?php esc_html_e( 'Portfolio de proyectos y actividades — del sector administrativo a frontend developer.', 'marcborrell' ); ?></p>
	</div>
</section>

<section class="container actividades-preview">
	<h2><?php esc_html_e( 'Proyectos / Actividades', 'marcborrell' ); ?></h2>

	<div class="actividades-grid">
		<?php
		$actividades_destacadas = new WP_Query(
			array(
				'post_type'      => 'actividad',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		if ( $actividades_destacadas->have_posts() ) :
			while ( $actividades_destacadas->have_posts() ) :
				$actividades_destacadas->the_post();
				get_template_part( 'template-parts/card-actividad' );
			endwhile;
			wp_reset_postdata();
		else :
			?>
			<p class="text-muted"><?php esc_html_e( 'Todavía no hay actividades publicadas.', 'marcborrell' ); ?></p>
			<?php
		endif;
		?>
	</div>

	<a class="btn-ver-todo" href="<?php echo esc_url( get_post_type_archive_link( 'actividad' ) ); ?>">
		<?php esc_html_e( 'Ver todos los proyectos →', 'marcborrell' ); ?>
	</a>
</section>

<section class="container sobre-mi-preview">
	<div class="sobre-mi-preview__avatar">
		<?php
		$sobre_mi_page = get_page_by_path( 'sobre-mi' );
		if ( $sobre_mi_page && has_post_thumbnail( $sobre_mi_page->ID ) ) {
			echo get_the_post_thumbnail(
				$sobre_mi_page->ID,
				'thumbnail',
				array(
					'class' => 'sobre-mi-preview__img',
					'alt'   => esc_attr__( 'Foto de Marc Borrell', 'marcborrell' ),
				)
			);
		}
		?>
	</div>
	<p>
		<?php
		$sobre_mi_excerpt = $sobre_mi_page ? get_the_excerpt( $sobre_mi_page ) : '';
		if ( ! empty( trim( $sobre_mi_excerpt ) ) ) {
			echo esc_html( wp_trim_words( $sobre_mi_excerpt, 25 ) );
		} else {
			esc_html_e( 'Del sector administrativo al desarrollo web — construyendo interfaces claras con lo que aprendo.', 'marcborrell' );
		}
		?>
	</p>
	<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'sobre-mi' ) ) ); ?>">
		<?php esc_html_e( 'Conóceme →', 'marcborrell' ); ?>
	</a>
</section>

<?php
get_footer();
