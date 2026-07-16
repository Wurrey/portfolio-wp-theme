<?php
/**
 * SEO automático para el CPT Actividad.
 *
 * Rank Math permite filtrar el título y la descripción SEO antes de
 * mostrarlos, sin necesidad de rellenar el snippet en cada actividad.
 * Este archivo genera automáticamente:
 * - Título: "Nombre de la actividad — Marc Borrell"
 * - Descripción: el extracto de la actividad, o los primeros 155
 *   caracteres del contenido si no hay extracto.
 *
 * @package MarcBorrell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Título SEO automático para actividades.
 * Solo actúa si no hay un título personalizado guardado en Rank Math.
 */
function marcborrell_seo_titulo_actividad( $title ) {
	if ( ! is_singular( 'actividad' ) ) {
		return $title;
	}

	// Si Rank Math ya tiene un título personalizado para esta actividad, lo respeta.
	$titulo_personalizado = get_post_meta( get_the_ID(), 'rank_math_title', true );
	if ( ! empty( $titulo_personalizado ) ) {
		return $title;
	}

	return get_the_title() . ' — Marc Borrell';
}
add_filter( 'rank_math/frontend/title', 'marcborrell_seo_titulo_actividad' );

/**
 * Meta description automática para actividades.
 * Solo actúa si no hay una descripción personalizada guardada en Rank Math.
 */
function marcborrell_seo_descripcion_actividad( $description ) {
	if ( ! is_singular( 'actividad' ) ) {
		return $description;
	}

	// Si Rank Math ya tiene una descripción personalizada, la respeta.
	$desc_personalizada = get_post_meta( get_the_ID(), 'rank_math_description', true );
	if ( ! empty( $desc_personalizada ) ) {
		return $description;
	}

	// Usar el extracto si existe, si no los primeros 155 caracteres del contenido.
	$extracto = get_the_excerpt();
	if ( ! empty( trim( $extracto ) ) ) {
		return wp_trim_words( $extracto, 25 );
	}

	$contenido = get_the_content();
	if ( ! empty( trim( $contenido ) ) ) {
		return wp_trim_words( wp_strip_all_tags( $contenido ), 25 );
	}

	return $description;
}
add_filter( 'rank_math/frontend/description', 'marcborrell_seo_descripcion_actividad' );
