<?php
/**
 * Template Name: Proceso
 *
 * Página de aterrizaje intermedia que agrupa los dos recursos externos
 * del proyecto final de curso: la Memoria (documentación del proceso)
 * y la Exposición (presentación ante el tribunal).
 *
 * Una vez finalizado el curso, basta con quitar el botón "Proceso ↗"
 * del header y footer para que esta página deje de ser accesible desde
 * la navegación principal, sin necesidad de tocar más código.
 *
 * @package MarcBorrell
 */

get_header();
?>

<section class="container proceso-landing">

	<header class="proceso-landing__intro">
		<h1><?php esc_html_e( 'El proceso', 'marcborrell' ); ?></h1>
		<p><?php esc_html_e( 'Este portfolio es el resultado visible. Aquí puedes explorar cómo se construyó — desde la documentación de cada decisión hasta la presentación final ante el tribunal.', 'marcborrell' ); ?></p>
	</header>

	<div class="proceso-landing__cards">

		<a class="proceso-card" href="<?php echo esc_url( home_url( '/memoria/' ) ); ?>" target="_blank" rel="noopener noreferrer">
			<div class="proceso-card__icono">
				<i class="bi bi-journal-text" aria-hidden="true"></i>
			</div>
			<div class="proceso-card__texto">
				<h2><?php esc_html_e( 'Memoria', 'marcborrell' ); ?></h2>
				<p><?php esc_html_e( 'Documentación completa del proceso de desarrollo — decisiones de diseño, tecnologías, problemas encontrados y cómo se resolvieron.', 'marcborrell' ); ?></p>
				<span class="proceso-card__cta">Ver Memoria &#x2197;&#xFE0E;</span>
			</div>
		</a>

		<a class="proceso-card" href="<?php echo esc_url( home_url( '/exposicion/' ) ); ?>" target="_blank" rel="noopener noreferrer">
			<div class="proceso-card__icono">
				<i class="bi bi-easel" aria-hidden="true"></i>
			</div>
			<div class="proceso-card__texto">
				<h2><?php esc_html_e( 'Exposición', 'marcborrell' ); ?></h2>
				<p><?php esc_html_e( 'Presentación del proyecto ante el tribunal — slides con el resumen del trabajo realizado, las tecnologías usadas y los resultados obtenidos.', 'marcborrell' ); ?></p>
				<span class="proceso-card__cta">Ver Exposición &#x2197;&#xFE0E;</span>
			</div>
		</a>

	</div>

	<div class="proceso-landing__contacto">
		<p>
			<?php esc_html_e( '¿Tienes alguna pregunta sobre el proyecto?', 'marcborrell' ); ?>
			<?php
			$email_publico = get_theme_mod( 'contacto_email_publico', '' );
			if ( empty( $email_publico ) ) {
				$email_publico = get_option( 'admin_email' );
			}
			if ( ! empty( $email_publico ) ) :
			?>
			<a href="mailto:<?php echo esc_attr( $email_publico ); ?>">
				<?php echo esc_html( $email_publico ); ?>
			</a>
			<?php endif; ?>
		</p>
	</div>

</section>

<?php
get_footer();
