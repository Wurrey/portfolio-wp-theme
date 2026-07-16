<?php
/**
 * Template Name: Contacto
 *
 * Layout en dos columnas en desktop/tablet (formulario + redes sociales
 * con descripción), apiladas en mobile. El email mostrado es configurable
 * desde Personalizar > Página de Contacto, independiente del admin_email
 * de WordPress (que sigue siendo donde llegan los mensajes del formulario).
 *
 * @package MarcBorrell
 */

get_header();

$estado = isset( $_GET['contacto'] ) ? sanitize_text_field( wp_unslash( $_GET['contacto'] ) ) : '';

$descripciones_social = array(
	'github'    => __( 'mis repositorios', 'marcborrell' ),
	'linkedin'  => __( 'mi trayectoria', 'marcborrell' ),
	'instagram' => __( 'proceso visual', 'marcborrell' ),
	'codepen'   => __( 'demos interactivas', 'marcborrell' ),
);
?>

<section class="container contacto">

	<?php while ( have_posts() ) : the_post(); ?>
		<header class="contacto__intro">
			<h1><?php the_title(); ?></h1>
			<?php
			$contenido = get_the_content();
			if ( ! empty( trim( wp_strip_all_tags( $contenido ) ) ) ) :
				the_content();
			else :
				?>
				<p><?php esc_html_e( '¿Tienes un proyecto en mente o quieres comentarme algo? Escríbeme por aquí o a través de mis redes.', 'marcborrell' ); ?></p>
			<?php endif; ?>
		</header>
	<?php endwhile; ?>

	<div class="contacto__body">

		<div class="contacto__form-col">

			<?php if ( 'ok' === $estado ) : ?>
				<p class="contacto__mensaje contacto__mensaje--ok" role="status">
					<?php esc_html_e( 'Gracias, tu mensaje se ha enviado correctamente.', 'marcborrell' ); ?>
				</p>
			<?php elseif ( 'error' === $estado ) : ?>
				<p class="contacto__mensaje contacto__mensaje--error" role="alert">
					<?php esc_html_e( 'Algo no ha ido bien. Revisa los datos e inténtalo de nuevo.', 'marcborrell' ); ?>
				</p>
			<?php endif; ?>

			<form class="contacto__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
				<input type="hidden" name="action" value="marcborrell_contacto">
				<?php wp_nonce_field( 'marcborrell_contacto', 'marcborrell_contacto_nonce' ); ?>

				<label for="nombre"><?php esc_html_e( 'Nombre', 'marcborrell' ); ?></label>
				<input type="text" id="nombre" name="nombre" placeholder="<?php esc_attr_e( 'Tu nombre', 'marcborrell' ); ?>" required>
				<span class="contacto__error" data-error-for="nombre" role="alert"></span>

				<label for="email"><?php esc_html_e( 'Email', 'marcborrell' ); ?></label>
				<input type="email" id="email" name="email" placeholder="tu@email.com" required>
				<span class="contacto__error" data-error-for="email" role="alert"></span>

				<label for="mensaje"><?php esc_html_e( 'Mensaje', 'marcborrell' ); ?></label>
				<textarea id="mensaje" name="mensaje" rows="6" placeholder="<?php esc_attr_e( 'Cuéntame en qué puedo ayudarte…', 'marcborrell' ); ?>" required></textarea>
				<span class="contacto__error" data-error-for="mensaje" role="alert"></span>

				<button type="submit" class="btn-enviar"><?php esc_html_e( 'Enviar', 'marcborrell' ); ?></button>
			</form>

		</div>

		<aside class="contacto__redes-col">
			<?php
			$email_publico = get_theme_mod( 'contacto_email_publico', '' );
			if ( empty( $email_publico ) ) {
				$email_publico = get_option( 'admin_email' );
			}
			?>
			<?php if ( ! empty( $email_publico ) ) : ?>
				<p class="contacto__email">
					<a href="mailto:<?php echo esc_attr( $email_publico ); ?>">
						<?php echo esc_html( $email_publico ); ?>
					</a>
				</p>
			<?php endif; ?>

			<ul class="contacto__social-lista">
				<?php foreach ( marcborrell_social_links() as $key => $social ) : ?>
					<li>
						<a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="contacto__social-item">
							<span class="contacto__social-icono">
								<?php if ( 'codepen' === $key ) : ?>
									<?php echo marcborrell_codepen_icon(); ?>
								<?php else : ?>
									<i class="bi <?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>
							</span>
							<span class="contacto__social-texto">
								<strong><?php echo esc_html( $social['label'] ); ?></strong>
								<small><?php echo esc_html( $descripciones_social[ $key ] ?? '' ); ?></small>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</aside>

	</div>

</section>

<?php
get_footer();
