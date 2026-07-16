<?php
/**
 * Metabox: Evolución y versiones.
 *
 * Permite añadir pasos con imagen + título + texto desde el editor de
 * WordPress, sin tocar código. Cada paso se alterna izquierda/derecha
 * en la plantilla single-actividad.php (tablet y desktop).
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra el metabox en el editor de Actividades.
 */
function marcborrell_evolucion_metabox() {
	add_meta_box(
		'marcborrell_evolucion',
		__( 'Evolución y versiones', 'marcborrell' ),
		'marcborrell_evolucion_render',
		'actividad',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'marcborrell_evolucion_metabox' );

/**
 * Renderiza el metabox.
 */
function marcborrell_evolucion_render( $post ) {
	wp_nonce_field( 'marcborrell_evolucion_save', 'marcborrell_evolucion_nonce' );

	$pasos = get_post_meta( $post->ID, 'actividad_evolucion', true );
	if ( empty( $pasos ) || ! is_array( $pasos ) ) {
		$pasos = array();
	}
	?>
	<div id="evolucion-pasos">
		<?php foreach ( $pasos as $i => $paso ) : ?>
			<div class="evolucion-paso" style="border:1px solid #ddd; padding:12px; margin-bottom:12px; border-radius:4px;">
				<p><strong><?php echo esc_html( sprintf( __( 'Paso %d', 'marcborrell' ), $i + 1 ) ); ?></strong>
				<button type="button" class="button evolucion-eliminar" style="float:right;color:#b32d2e;"><?php esc_html_e( 'Eliminar paso', 'marcborrell' ); ?></button></p>

				<p><label><?php esc_html_e( 'Título del paso', 'marcborrell' ); ?></label><br>
				<input type="text" name="evolucion_titulo[]"
					   value="<?php echo esc_attr( $paso['titulo'] ?? '' ); ?>"
					   style="width:100%;"></p>

				<p><label><?php esc_html_e( 'Descripción', 'marcborrell' ); ?></label><br>
				<textarea name="evolucion_texto[]" rows="3"
						  style="width:100%;"><?php echo esc_textarea( $paso['texto'] ?? '' ); ?></textarea></p>

				<p><label><?php esc_html_e( 'Imagen (ID de adjunto o URL)', 'marcborrell' ); ?></label><br>
				<input type="text" name="evolucion_imagen[]"
					   value="<?php echo esc_attr( $paso['imagen_id'] ?? '' ); ?>"
					   style="width:80%; margin-right:8px;" class="evolucion-imagen-input">
				<button type="button" class="button evolucion-imagen-btn"><?php esc_html_e( 'Seleccionar imagen', 'marcborrell' ); ?></button></p>

				<?php if ( ! empty( $paso['imagen_id'] ) ) : ?>
					<div class="evolucion-preview">
						<?php
						if ( is_numeric( $paso['imagen_id'] ) ) {
							echo wp_get_attachment_image( (int) $paso['imagen_id'], array( 150, 100 ) );
						} else {
							echo '<img src="' . esc_url( $paso['imagen_id'] ) . '" style="max-width:150px;max-height:100px;">';
						}
						?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

	<button type="button" class="button button-primary" id="evolucion-añadir">
		<?php esc_html_e( '+ Añadir paso', 'marcborrell' ); ?>
	</button>

	<script>
	(function($) {
		var contador = <?php echo count( $pasos ); ?>;

		// Abrir el selector de medios de WordPress
		function abrirMediaSelector(btn) {
			var frame = wp.media({
				title: '<?php esc_html_e( 'Seleccionar imagen del paso', 'marcborrell' ); ?>',
				button: { text: '<?php esc_html_e( 'Usar esta imagen', 'marcborrell' ); ?>' },
				multiple: false
			});
			frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				var paso = $(btn).closest('.evolucion-paso');
				paso.find('.evolucion-imagen-input').val(attachment.id);
				var preview = paso.find('.evolucion-preview');
				if (!preview.length) {
					paso.append('<div class="evolucion-preview"></div>');
					preview = paso.find('.evolucion-preview');
				}
				preview.html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width:150px;max-height:100px;">');
			});
			frame.open();
		}

		$(document).on('click', '.evolucion-imagen-btn', function() {
			abrirMediaSelector(this);
		});

		// Añadir nuevo paso
		$('#evolucion-añadir').on('click', function() {
			contador++;
			var html = '<div class="evolucion-paso" style="border:1px solid #ddd; padding:12px; margin-bottom:12px; border-radius:4px;">' +
				'<p><strong><?php esc_html_e( 'Paso', 'marcborrell' ); ?> ' + contador + '</strong>' +
				'<button type="button" class="button evolucion-eliminar" style="float:right;color:#b32d2e;"><?php esc_html_e( 'Eliminar paso', 'marcborrell' ); ?></button></p>' +
				'<p><label><?php esc_html_e( 'Título del paso', 'marcborrell' ); ?></label><br>' +
				'<input type="text" name="evolucion_titulo[]" style="width:100%;"></p>' +
				'<p><label><?php esc_html_e( 'Descripción', 'marcborrell' ); ?></label><br>' +
				'<textarea name="evolucion_texto[]" rows="3" style="width:100%;"></textarea></p>' +
				'<p><label><?php esc_html_e( 'Imagen', 'marcborrell' ); ?></label><br>' +
				'<input type="text" name="evolucion_imagen[]" style="width:80%; margin-right:8px;" class="evolucion-imagen-input">' +
				'<button type="button" class="button evolucion-imagen-btn"><?php esc_html_e( 'Seleccionar imagen', 'marcborrell' ); ?></button></p>' +
				'</div>';
			$('#evolucion-pasos').append(html);
		});

		// Eliminar paso
		$(document).on('click', '.evolucion-eliminar', function() {
			if (confirm('<?php esc_html_e( '¿Eliminar este paso?', 'marcborrell' ); ?>')) {
				$(this).closest('.evolucion-paso').remove();
			}
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Guarda los datos del metabox al publicar/actualizar la actividad.
 */
function marcborrell_evolucion_save( $post_id ) {
	if ( ! isset( $_POST['marcborrell_evolucion_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['marcborrell_evolucion_nonce'] ) ), 'marcborrell_evolucion_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$titulos  = isset( $_POST['evolucion_titulo'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['evolucion_titulo'] ) ) : array();
	$textos   = isset( $_POST['evolucion_texto'] ) ? array_map( 'sanitize_textarea_field', wp_unslash( $_POST['evolucion_texto'] ) ) : array();
	$imagenes = isset( $_POST['evolucion_imagen'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['evolucion_imagen'] ) ) : array();

	$pasos = array();
	$total = max( count( $titulos ), count( $textos ), count( $imagenes ) );

	for ( $i = 0; $i < $total; $i++ ) {
		$titulo = $titulos[ $i ] ?? '';
		$texto  = $textos[ $i ] ?? '';
		$imagen = $imagenes[ $i ] ?? '';

		// Solo guarda el paso si tiene al menos título o imagen.
		if ( ! empty( $titulo ) || ! empty( $imagen ) ) {
			$pasos[] = array(
				'titulo'    => $titulo,
				'texto'     => $texto,
				'imagen_id' => $imagen,
			);
		}
	}

	if ( ! empty( $pasos ) ) {
		update_post_meta( $post_id, 'actividad_evolucion', $pasos );
	} else {
		delete_post_meta( $post_id, 'actividad_evolucion' );
	}
}
add_action( 'save_post_actividad', 'marcborrell_evolucion_save' );
