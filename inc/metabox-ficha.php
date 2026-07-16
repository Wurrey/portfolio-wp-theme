<?php
/**
 * Metabox: Ficha — conceptos clave.
 *
 * Formato: un párrafo breve en primera persona ("Aprendí...") + una
 * cita destacada que resume el concepto central de la actividad.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marcborrell_ficha_metabox() {
	add_meta_box(
		'marcborrell_ficha',
		__( 'Ficha — conceptos clave', 'marcborrell' ),
		'marcborrell_ficha_render',
		'actividad',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'marcborrell_ficha_metabox' );

function marcborrell_ficha_render( $post ) {
	wp_nonce_field( 'marcborrell_ficha_save', 'marcborrell_ficha_nonce' );

	$resumen = get_post_meta( $post->ID, 'actividad_ficha_resumen', true );
	$cita    = get_post_meta( $post->ID, 'actividad_ficha_cita', true );
	?>
	<p style="font-size:12px;color:#666;margin-bottom:8px;">
		<?php esc_html_e( 'Un párrafo breve sobre lo aprendido + una cita destacada con el concepto central.', 'marcborrell' ); ?>
	</p>

	<p>
		<label for="ficha_resumen"><strong><?php esc_html_e( 'Resumen del aprendizaje', 'marcborrell' ); ?></strong></label><br>
		<textarea id="ficha_resumen" name="ficha_resumen" rows="5"
				  style="width:100%;margin-top:4px;"><?php echo esc_textarea( $resumen ); ?></textarea>
	</p>

	<p>
		<label for="ficha_cita"><strong><?php esc_html_e( 'Cita destacada', 'marcborrell' ); ?></strong></label><br>
		<textarea id="ficha_cita" name="ficha_cita" rows="2"
				  style="width:100%;margin-top:4px;"><?php echo esc_textarea( $cita ); ?></textarea>
	</p>
	<?php
}

function marcborrell_ficha_save( $post_id ) {
	if ( ! isset( $_POST['marcborrell_ficha_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['marcborrell_ficha_nonce'] ) ), 'marcborrell_ficha_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['ficha_resumen'] ) ) {
		update_post_meta( $post_id, 'actividad_ficha_resumen', sanitize_textarea_field( wp_unslash( $_POST['ficha_resumen'] ) ) );
	}

	if ( isset( $_POST['ficha_cita'] ) ) {
		update_post_meta( $post_id, 'actividad_ficha_cita', sanitize_textarea_field( wp_unslash( $_POST['ficha_cita'] ) ) );
	}
}
add_action( 'save_post_actividad', 'marcborrell_ficha_save' );

/**
 * Expone los campos de la ficha en la API REST para poder rellenarlos
 * de forma automatizada (usado puntualmente para la carga inicial).
 */
function marcborrell_registrar_meta_rest() {
	register_post_meta(
		'actividad',
		'actividad_ficha_resumen',
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	register_post_meta(
		'actividad',
		'actividad_ficha_cita',
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
}
add_action( 'init', 'marcborrell_registrar_meta_rest' );
