<?php
/**
 * Procesa el formulario de contacto y envía un email con wp_mail().
 *
 * El formulario envía a admin-post.php (patrón estándar de WordPress
 * para procesar formularios sin plugins), con verificación de nonce
 * para evitar envíos automatizados/spam básico.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marcborrell_handle_contact_form() {
	if ( ! isset( $_POST['marcborrell_contacto_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['marcborrell_contacto_nonce'] ) ), 'marcborrell_contacto' ) ) {
		wp_die( esc_html__( 'No se pudo verificar el formulario. Vuelve a intentarlo.', 'marcborrell' ) );
	}

	$nombre  = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$mensaje = isset( $_POST['mensaje'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensaje'] ) ) : '';

	$pagina_origen = wp_get_referer() ? wp_get_referer() : home_url( '/contacto/' );

	if ( empty( $nombre ) || empty( $mensaje ) || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contacto', 'error', $pagina_origen ) );
		exit;
	}

    $destinatario = get_theme_mod( 'contacto_email_publico' );
if ( empty( $destinatario ) ) {
    $destinatario = get_option( 'admin_email' );
}
	$asunto       = sprintf( '[%s] Nuevo mensaje de contacto de %s', get_bloginfo( 'name' ), $nombre );
	$cuerpo       = "Nombre: {$nombre}\nEmail: {$email}\n\nMensaje:\n{$mensaje}";
	$cabeceras    = array( 'Reply-To: ' . $nombre . ' <' . $email . '>' );

	$enviado = wp_mail( $destinatario, $asunto, $cuerpo, $cabeceras );

	wp_safe_redirect( add_query_arg( 'contacto', $enviado ? 'ok' : 'error', $pagina_origen ) );
	exit;
}
add_action( 'admin_post_marcborrell_contacto', 'marcborrell_handle_contact_form' );
add_action( 'admin_post_nopriv_marcborrell_contacto', 'marcborrell_handle_contact_form' );