<?php
/**
 * Opciones del Customizer de WordPress.
 * Permite gestionar la imagen del hero de Inicio sin tocar código.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marcborrell_customizer_register( $wp_customize ) {

	// -----------------------------------------------------------------------
	// Sección: Portada
	// -----------------------------------------------------------------------
	$wp_customize->add_section(
		'marcborrell_portada',
		array(
			'title'    => __( 'Portada — Inicio', 'marcborrell' ),
			'priority' => 30,
		)
	);

	// Imagen del hero
	$wp_customize->add_setting(
		'hero_image_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'hero_image_url',
			array(
				'label'       => __( 'Imagen del hero (portada)', 'marcborrell' ),
				'description' => __( 'Recomendado: 1440×560px. La imagen que aparece de fondo en el encabezado de la portada.', 'marcborrell' ),
				'section'     => 'marcborrell_portada',
				'settings'    => 'hero_image_url',
			)
		)
	);
	// -----------------------------------------------------------------------
	// Sección: Contacto
	// -----------------------------------------------------------------------
	$wp_customize->add_section(
		'marcborrell_contacto',
		array(
			'title'    => __( 'Página de Contacto', 'marcborrell' ),
			'priority' => 31,
		)
	);

	// Email público mostrado en la página de Contacto.
	// Independiente del admin_email de WordPress: ese sigue usándose para
	// recibir los mensajes del formulario, pero el que se MUESTRA al
	// visitante puede ser un correo distinto (el profesional de Marc).
	$wp_customize->add_setting(
		'contacto_email_publico',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'contacto_email_publico',
		array(
			'label'       => __( 'Email mostrado en Contacto', 'marcborrell' ),
			'description' => __( 'El correo que ve el visitante. Si lo dejas vacío, se usa el email de administración de WordPress (Ajustes > Generales).', 'marcborrell' ),
			'section'     => 'marcborrell_contacto',
			'type'        => 'email',
		)
	);
}
add_action( 'customize_register', 'marcborrell_customizer_register' );
