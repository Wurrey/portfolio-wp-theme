<?php
/**
 * Listado de actividades: pills de filtro + grid + "Cargar más".
 *
 * Se incluye tanto desde archive-actividad.php (todas las actividades)
 * como desde taxonomy-tecnologia.php (filtradas por una tecnología),
 * para no duplicar el mismo marcado en dos plantillas.
 *
 * Usa el Loop principal de WordPress (have_posts() / the_post()) en
 * lugar de un WP_Query manual: como tanto el archive del CPT como la
 * taxonomy ya vienen filtrados correctamente por WordPress según la
 * URL visitada, no hace falta volver a consultar la base de datos.
 *
 * @package MarcBorrell
 */

$terminos     = get_terms( array( 'taxonomy' => 'tecnologia', 'hide_empty' => false ) );
$slug_activo  = is_tax( 'tecnologia' ) ? get_queried_object()->slug : 'todos';
$orden_activo = isset( $_GET['orden'] ) && 'asc' === $_GET['orden'] ? 'asc' : 'desc';
?>

<section class="container proyectos-filtros" aria-label="<?php esc_attr_e( 'Filtrar por tecnología', 'marcborrell' ); ?>">
	<ul class="filtro-pills" id="filtro-tecnologia">
		<li>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'actividad' ) ); ?>"
			   class="filtro-pill <?php echo 'todos' === $slug_activo ? 'is-active' : ''; ?>"
			   data-tecnologia="todos">
				<?php esc_html_e( 'Todos', 'marcborrell' ); ?>
			</a>
		</li>
		<?php foreach ( $terminos as $termino ) : ?>
			<li>
				<a href="<?php echo esc_url( get_term_link( $termino ) ); ?>"
				   class="filtro-pill <?php echo $termino->slug === $slug_activo ? 'is-active' : ''; ?>"
				   data-tecnologia="<?php echo esc_attr( $termino->slug ); ?>">
					<?php echo esc_html( $termino->name ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<div class="proyectos-orden" id="orden-actividades" aria-label="<?php esc_attr_e( 'Ordenar actividades', 'marcborrell' ); ?>">
		<button type="button" class="orden-btn <?php echo 'desc' === $orden_activo ? 'is-active' : ''; ?>" data-orden="desc">
			<?php esc_html_e( 'Más reciente', 'marcborrell' ); ?>
		</button>
		<button type="button" class="orden-btn <?php echo 'asc' === $orden_activo ? 'is-active' : ''; ?>" data-orden="asc">
			<?php esc_html_e( 'Más antiguo', 'marcborrell' ); ?>
		</button>
	</div>
</section>

<section class="container">
	<div class="actividades-grid" id="actividades-grid" data-pagina="1" data-orden="<?php echo esc_attr( $orden_activo ); ?>">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card-actividad' );
			endwhile;
		else :
			?>
			<p class="text-muted"><?php esc_html_e( 'No hay actividades con esta tecnología todavía.', 'marcborrell' ); ?></p>
			<?php
		endif;
		?>
	</div>

	<?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
		<button type="button" id="cargar-mas" class="btn-cargar-mas">
			<?php esc_html_e( 'Cargar más', 'marcborrell' ); ?>
		</button>
	<?php endif; ?>

	<p id="actividades-vacio" class="text-muted" hidden>
		<?php esc_html_e( 'No hay actividades con esta tecnología todavía.', 'marcborrell' ); ?>
	</p>
</section>
