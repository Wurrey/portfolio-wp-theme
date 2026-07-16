<?php
/**
 * Template Name: Sobre mí
 *
 * El texto de presentación, los hitos de "Mi trayectoria" y el CTA son
 * fijos en la plantilla (igual que en el diseño de Figma) para que la
 * página tenga contenido real desde el primer momento.
 *
 * @package MarcBorrell
 */

get_header();

// Schema markup: Person — le dice a Google y a las IAs exactamente quién es Marc,
// con nombre, URL, habilidades y redes sociales estructuradas.
// Se inyecta inline en la página porque afecta solo a esta plantilla.
$schema_person = array(
	'@context'        => 'https://schema.org',
	'@type'           => 'Person',
	'name'            => 'Marc Borrell',
	'url'             => 'https://wurrey.com',
	'jobTitle'        => 'Frontend Developer en formación',
	'description'     => 'Del sector administrativo al desarrollo web. Portfolio de proyectos y actividades del curso de desarrollo web.',
	'knowsAbout'      => array( 'HTML', 'CSS', 'JavaScript', 'Bootstrap', 'WordPress', 'Figma' ),
	'sameAs'          => array(
		'https://github.com/Wurrey',
		'https://www.linkedin.com/in/marc-borrell-capdevila-2b3539101',
		'https://www.instagram.com/marcborrellcapdevila/',
		'https://codepen.io/Wurrey',
	),
	'image'           => get_the_post_thumbnail_url( get_page_by_path( 'sobre-mi' ), 'large' ),
	'mainEntityOfPage' => array(
		'@type' => 'WebPage',
		'@id'   => 'https://wurrey.com/sobre-mi/',
	),
);

echo '<script type="application/ld+json">' . wp_json_encode( $schema_person, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";

while ( have_posts() ) :
	the_post();
	?>

	<article class="container sobre-mi">

		<div class="sobre-mi__foto">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail(
					'large',
					array(
						'class' => 'sobre-mi__foto-img',
						'alt'   => esc_attr__( 'Foto de Marc Borrell', 'marcborrell' ),
					)
				);
			}
			?>
		</div>

		<div class="sobre-mi__intro">
			<h1><?php the_title(); ?></h1>

			<?php
			$contenido = get_the_content();
			if ( ! empty( trim( wp_strip_all_tags( $contenido ) ) ) ) :
				?>
				<div class="sobre-mi__contenido">
					<?php the_content(); ?>
				</div>
			<?php else : ?>
				<p class="sobre-mi__intro-texto">
					<?php esc_html_e( 'Vengo del sector administrativo y contable, y durante este curso he descubierto que lo que más me motiva es construir interfaces claras y accesibles. Este portfolio reúne ese camino.', 'marcborrell' ); ?>
				</p>
			<?php endif; ?>
		</div>

		<section class="sobre-mi__trayectoria">
			<h2><?php esc_html_e( 'Mi trayectoria', 'marcborrell' ); ?></h2>
			<ol class="trayectoria-lista">
				<li>
					<span class="trayectoria-lista__marcador" aria-hidden="true"></span>
					<?php esc_html_e( 'Administración y contabilidad', 'marcborrell' ); ?>
				</li>
				<li>
					<span class="trayectoria-lista__marcador" aria-hidden="true"></span>
					<?php esc_html_e( 'Explorando el cambio', 'marcborrell' ); ?>
				</li>
				<li>
					<span class="trayectoria-lista__marcador" aria-hidden="true"></span>
					<?php esc_html_e( 'Curso de desarrollo web', 'marcborrell' ); ?>
				</li>
				<li>
					<span class="trayectoria-lista__marcador" aria-hidden="true"></span>
					<?php esc_html_e( 'Construyendo lo que viene', 'marcborrell' ); ?>
				</li>
			</ol>
		</section>

		<section class="sobre-mi__tecnologias">
			<h2><?php esc_html_e( 'Tecnologías', 'marcborrell' ); ?></h2>
			<ul class="tech-pills tech-pills--grande">
				<?php
				$tecnologias = array( 'HTML', 'CSS', 'JavaScript', 'Bootstrap', 'WordPress', 'Figma' );
				foreach ( $tecnologias as $tecnologia ) :
					?>
					<li class="tech-pill"><?php echo esc_html( $tecnologia ); ?></li>
				<?php endforeach; ?>
			</ul>
		</section>

		<a class="btn-hablemos" href="<?php echo esc_url( get_permalink( get_page_by_path( 'contacto' ) ) ); ?>">
			<?php esc_html_e( 'Hablemos →', 'marcborrell' ); ?>
		</a>

	</article>

	<?php
endwhile;

get_footer();
