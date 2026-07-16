<?php
/**
 * Header: logo "Marc Borrell.", menú principal, hamburguesa móvil.
 *
 * @package MarcBorrell
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="preloader" aria-hidden="true">
	<div class="preloader__spinner"></div>
</div>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Saltar al contenido', 'marcborrell' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">

		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?><span class="site-logo__dot">.</span>
		</a>

		<button class="nav-toggle" aria-expanded="false" aria-controls="primary-menu">
			<span class="nav-toggle__bar"></span>
			<span class="nav-toggle__bar"></span>
			<span class="nav-toggle__bar"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Abrir menú', 'marcborrell' ); ?></span>
		</button>

		<nav class="site-nav" id="primary-menu" aria-label="<?php esc_attr_e( 'Menú principal', 'marcborrell' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'nav-menu',
						'depth'          => 1,
					)
				);
			} else {
				marcborrell_fallback_menu();
			}
			?>
			<a class="nav-proceso" href="<?php echo esc_url( home_url( '/proceso/' ) ); ?>">
				Proceso &#x2197;&#xFE0E;
			</a>
		</nav>

	</div>
	<div id="scroll-progress" aria-hidden="true"></div>
</header>

<main id="main-content" class="site-main">