</main><!-- /.site-main -->

<footer class="site-footer">
	<div class="container site-footer__inner">

		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Enlaces del footer', 'marcborrell' ); ?>">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'footer-nav__list',
						'depth'          => 1,
					)
				);
			} else {
				marcborrell_fallback_menu();
			}
			?>
		</nav>

		<a class="footer-proceso" href="<?php echo esc_url( home_url( '/proceso/' ) ); ?>">
			Proceso &#x2197;&#xFE0E;
		</a>

		<ul class="social-links">
			<?php foreach ( marcborrell_social_links() as $key => $social ) : ?>
				<li>
					<a href="<?php echo esc_url( $social['url'] ); ?>"
					   class="social-links__item"
					   target="_blank" rel="me noopener noreferrer"
					   aria-label="<?php echo esc_attr( $social['label'] ); ?>">
						<?php if ( 'codepen' === $key ) : ?>
							<?php echo marcborrell_codepen_icon(); // SVG inline — Bootstrap Icons no incluye CodePen ?>
						<?php else : ?>
							<i class="bi <?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<p class="footer-copy">
			&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — proyecto final de curso
		</p>

	</div>
</footer>

<button id="btn-volver-arriba" aria-label="<?php esc_attr_e( 'Volver al inicio de la página', 'marcborrell' ); ?>">
	<i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>