/**
 * main.js — Comportamiento del sitio:
 * 1. Preloader
 * 2. Menú hamburguesa móvil
 * 3. Filtro de tecnología (Proyectos/Actividades)
 * 4. Botón "Cargar más"
 * 5. Barra de progreso de scroll
 * 6. Botón "Volver arriba"
 * 7. Animaciones de entrada al hacer scroll
 * 8. Modal de imagen (single actividad)
 */
( function () {
	'use strict';

	/* ----------------------------------------------------------------
	 * 1. Preloader
	 * ---------------------------------------------------------------- */
	var preloader = document.getElementById( 'preloader' );

	if ( preloader ) {
		window.addEventListener( 'load', function () {
			preloader.classList.add( 'is-hidden' );
			// Eliminarlo del DOM después de la transición para no interferir
			preloader.addEventListener( 'transitionend', function () {
				if ( preloader.parentNode ) {
					preloader.parentNode.removeChild( preloader );
				}
			} );
		} );
	}

	/* ----------------------------------------------------------------
	 * 1. Menú móvil
	 * ---------------------------------------------------------------- */
	var navToggle = document.querySelector( '.nav-toggle' );
	var siteNav = document.querySelector( '.site-nav' );

	if ( navToggle && siteNav ) {
		navToggle.addEventListener( 'click', function () {
			var isOpen = navToggle.getAttribute( 'aria-expanded' ) === 'true';
			navToggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
			siteNav.classList.toggle( 'is-open', ! isOpen );
			document.body.classList.toggle( 'nav-open', ! isOpen );
		} );
	}

	/* ----------------------------------------------------------------
	 * 2 y 3. Filtro de tecnología + Cargar más
	 * (solo se ejecuta en la página de Proyectos/Actividades, donde
	 * existen estos elementos en el DOM)
	 * ---------------------------------------------------------------- */
	var grid = document.getElementById( 'actividades-grid' );
	var filtros = document.getElementById( 'filtro-tecnologia' );
	var ordenControl = document.getElementById( 'orden-actividades' );
	var botonCargarMas = document.getElementById( 'cargar-mas' );
	var mensajeVacio = document.getElementById( 'actividades-vacio' );

	if ( grid && typeof marcborrellData !== 'undefined' ) {
		var pillActiva = filtros ? filtros.querySelector( '.filtro-pill.is-active' ) : null;
		var tecnologiaActiva = pillActiva ? pillActiva.getAttribute( 'data-tecnologia' ) : 'todos';
		var ordenActivo = grid.getAttribute( 'data-orden' ) || 'desc';
		var paginaActual = 1;

		function actualizarUrlOrden( orden ) {
			if ( ! ( window.history && window.history.pushState ) ) {
				return;
			}
			var url = new URL( window.location.href );
			if ( 'asc' === orden ) {
				url.searchParams.set( 'orden', 'asc' );
			} else {
				url.searchParams.delete( 'orden' );
			}
			window.history.pushState( {}, '', url );
		}

		function pedirActividades( pagina, tecnologia, orden, reemplazar ) {
			var datos = new FormData();
			datos.append( 'action', 'marcborrell_load_actividades' );
			datos.append( 'nonce', marcborrellData.nonce );
			datos.append( 'pagina', pagina );
			datos.append( 'tecnologia', tecnologia );
			datos.append( 'orden', orden );

			if ( botonCargarMas ) {
				botonCargarMas.disabled = true;
				botonCargarMas.textContent = 'Cargando…';
			}

			fetch( marcborrellData.ajaxUrl, { method: 'POST', body: datos } )
				.then( function ( respuesta ) {
					return respuesta.json();
				} )
				.then( function ( resultado ) {
					if ( ! resultado.success ) {
						return;
					}

					if ( reemplazar ) {
						grid.innerHTML = resultado.data.html;
					} else {
						grid.insertAdjacentHTML( 'beforeend', resultado.data.html );
					}

					// Animar las tarjetas nuevas que acaban de entrar en el DOM
					if ( observador ) {
						observarElementos( grid );
					}

					if ( mensajeVacio ) {
						mensajeVacio.hidden = grid.children.length > 0;
					}

					if ( botonCargarMas ) {
						botonCargarMas.hidden = ! resultado.data.hasMore;
						botonCargarMas.disabled = false;
						botonCargarMas.textContent = 'Cargar más';
					}
				} )
				.catch( function () {
					if ( botonCargarMas ) {
						botonCargarMas.disabled = false;
						botonCargarMas.textContent = 'Cargar más';
					}
				} );
		}

		if ( filtros ) {
			filtros.addEventListener( 'click', function ( evento ) {
				var enlace = evento.target.closest( '.filtro-pill' );
				if ( ! enlace ) {
					return;
				}

				// Los pills son enlaces reales (a /actividades/ o /tecnologia/slug/)
				// para que cada filtro tenga una URL compartible y rastreable.
				// Aquí interceptamos el clic para mantener la experiencia "in-page"
				// ya decidida (sin recarga de página, sin dropdown).
				evento.preventDefault();

				filtros.querySelectorAll( '.filtro-pill' ).forEach( function ( pill ) {
					pill.classList.remove( 'is-active' );
				} );
				enlace.classList.add( 'is-active' );

				tecnologiaActiva = enlace.getAttribute( 'data-tecnologia' );
				paginaActual = 1;
				pedirActividades( paginaActual, tecnologiaActiva, ordenActivo, true );

				if ( window.history && window.history.pushState ) {
					window.history.pushState( {}, '', enlace.getAttribute( 'href' ) );
				}
			} );
		}

		if ( ordenControl ) {
			ordenControl.addEventListener( 'click', function ( evento ) {
				var boton = evento.target.closest( '.orden-btn' );
				if ( ! boton ) {
					return;
				}

				var nuevoOrden = boton.getAttribute( 'data-orden' );
				if ( nuevoOrden === ordenActivo ) {
					return;
				}

				ordenControl.querySelectorAll( '.orden-btn' ).forEach( function ( b ) {
					b.classList.remove( 'is-active' );
				} );
				boton.classList.add( 'is-active' );

				ordenActivo = nuevoOrden;
				paginaActual = 1;
				pedirActividades( paginaActual, tecnologiaActiva, ordenActivo, true );
				actualizarUrlOrden( ordenActivo );
			} );
		}

		if ( botonCargarMas ) {
			botonCargarMas.addEventListener( 'click', function () {
				paginaActual += 1;
				pedirActividades( paginaActual, tecnologiaActiva, ordenActivo, false );
			} );
		}
	}

	/* ----------------------------------------------------------------
	 * 4. Barra de progreso de scroll
	 * ---------------------------------------------------------------- */
	var barraPogreso = document.getElementById( 'scroll-progress' );

	if ( barraPogreso ) {
		window.addEventListener( 'scroll', function () {
			var scrollTotal = document.documentElement.scrollHeight - window.innerHeight;
			var scrollActual = window.scrollY;
			var porcentaje = scrollTotal > 0 ? ( scrollActual / scrollTotal ) * 100 : 0;
			barraPogreso.style.width = porcentaje + '%';
		} );
	}

	/* ----------------------------------------------------------------
	 * 5. Botón "Volver arriba"
	 * ---------------------------------------------------------------- */
	var btnArriba = document.getElementById( 'btn-volver-arriba' );

	if ( btnArriba ) {
		// Mostrar/ocultar según posición del scroll
		window.addEventListener( 'scroll', function () {
			if ( window.scrollY > 400 ) {
				btnArriba.classList.add( 'is-visible' );
			} else {
				btnArriba.classList.remove( 'is-visible' );
			}
		} );

		// Scroll suave al pulsar
		btnArriba.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}

	/* ----------------------------------------------------------------
	 * 7. Animaciones de entrada al hacer scroll (respeta prefers-reduced-motion)
	 * ---------------------------------------------------------------- */
	var prefiereMenosMovimiento = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var observador = null;

	if ( ! prefiereMenosMovimiento && 'IntersectionObserver' in window ) {
		observador = new IntersectionObserver(
			function ( entradas ) {
				entradas.forEach( function ( entrada ) {
					if ( entrada.isIntersecting ) {
						entrada.target.classList.add( 'is-visible' );
						observador.unobserve( entrada.target );
					}
				} );
			},
			{ threshold: 0.1 }
		);

		// Observar los elementos que ya están en el DOM al cargar
		function observarElementos( contenedor ) {
			var elementos = ( contenedor || document ).querySelectorAll( '[data-animar]' );
			elementos.forEach( function ( el ) {
				observador.observe( el );
			} );
		}

		observarElementos();
	}
	/* ----------------------------------------------------------------
	 * 8. Modal de imagen — single de actividad (actividad 19)
	 * JavaScript crea los elementos del modal dinámicamente al hacer
	 * clic, sin necesidad de escribirlos a mano en el HTML.
	 * ---------------------------------------------------------------- */
	var imagenesModal = document.querySelectorAll( '.actividad-evolucion__media img' );

	if ( imagenesModal.length > 0 ) {
		// Crear el overlay del modal una sola vez
		var modal = document.createElement( 'div' );
		modal.id = 'imagen-modal';
		modal.setAttribute( 'role', 'dialog' );
		modal.setAttribute( 'aria-modal', 'true' );
		modal.setAttribute( 'aria-label', 'Imagen ampliada' );

		var modalImg = document.createElement( 'img' );
		modalImg.className = 'imagen-modal__img';

		var modalCaption = document.createElement( 'p' );
		modalCaption.className = 'imagen-modal__caption';

		var modalCerrar = document.createElement( 'button' );
		modalCerrar.className = 'imagen-modal__cerrar';
		modalCerrar.setAttribute( 'aria-label', 'Cerrar imagen' );
		modalCerrar.innerHTML = '<i class="bi bi-x-lg" aria-hidden="true"></i>';

		modal.appendChild( modalCerrar );
		modal.appendChild( modalImg );
		modal.appendChild( modalCaption );
		document.body.appendChild( modal );

		function abrirModal( src, alt ) {
			modalImg.src = src;
			modalImg.alt = alt || '';
			modalCaption.textContent = alt || '';
			modal.classList.add( 'is-open' );
			document.body.classList.add( 'modal-open' );
		}

		function cerrarModal() {
			modal.classList.remove( 'is-open' );
			document.body.classList.remove( 'modal-open' );
		}

		imagenesModal.forEach( function ( img ) {
			img.style.cursor = 'zoom-in';
			img.addEventListener( 'click', function () {
				abrirModal( img.src, img.alt );
			} );
		} );

		modalCerrar.addEventListener( 'click', cerrarModal );

		// Cerrar al hacer clic fuera de la imagen
		modal.addEventListener( 'click', function ( e ) {
			if ( e.target === modal ) {
				cerrarModal();
			}
		} );

		// Cerrar con la tecla Escape
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && modal.classList.contains( 'is-open' ) ) {
				cerrarModal();
			}
		} );
	}

	/* ----------------------------------------------------------------
	 * 9. Validación del formulario de Contacto, con mensajes por campo
	 * (el atributo "required" se quita vía novalidate y se sustituye
	 * por esta validación propia en JavaScript — actividad 11/14 del
	 * curso: formularios + estructuras condicionales)
	 * ---------------------------------------------------------------- */
	var formContacto = document.querySelector( '.contacto__form' );

	if ( formContacto ) {
		var mensajesError = {
			nombre: 'Escribe tu nombre.',
			email: 'Escribe un email válido (ej. tu@email.com).',
			mensaje: 'Cuéntame algo antes de enviar el mensaje.'
		};

		function validarCampo( campo ) {
			var contenedorError = formContacto.querySelector( '[data-error-for="' + campo.name + '"]' );
			var valor = campo.value.trim();
			var esValido = true;

			if ( campo.hasAttribute( 'required' ) && valor === '' ) {
				esValido = false;
			} else if ( 'email' === campo.type && valor !== '' ) {
				var patronEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				esValido = patronEmail.test( valor );
			}

			campo.classList.toggle( 'is-invalido', ! esValido );

			if ( contenedorError ) {
				contenedorError.textContent = esValido ? '' : ( mensajesError[ campo.name ] || 'Revisa este campo.' );
			}

			return esValido;
		}

		formContacto.querySelectorAll( 'input, textarea' ).forEach( function ( campo ) {
			campo.addEventListener( 'blur', function () {
				validarCampo( campo );
			} );
		} );

		formContacto.addEventListener( 'submit', function ( evento ) {
			var camposAValidar = formContacto.querySelectorAll( 'input[name], textarea[name]' );
			var formularioValido = true;

			camposAValidar.forEach( function ( campo ) {
				if ( ! validarCampo( campo ) ) {
					formularioValido = false;
				}
			} );

			if ( ! formularioValido ) {
				evento.preventDefault();
				var primerCampoInvalido = formContacto.querySelector( '.is-invalido' );
				if ( primerCampoInvalido ) {
					primerCampoInvalido.focus();
				}
			}
		} );
	}

} )();
