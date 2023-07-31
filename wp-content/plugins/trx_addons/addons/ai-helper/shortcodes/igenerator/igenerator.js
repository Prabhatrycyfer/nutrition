/**
 * Shortcode IGenerator - Generate images with AI
 *
 * @package ThemeREX Addons
 * @since v2.20.2
 */

/* global jQuery, TRX_ADDONS_STORAGE */


jQuery( document ).ready( function() {

	"use strict";

	var $window             = jQuery( window ),
		$document           = jQuery( document ),
		$body               = jQuery( 'body' );

	$document.on( 'action.init_hidden_elements', function(e, container) {

		if ( container === undefined ) {
			container = $body;
		}

		// Init IGenerator
		container.find( '.sc_igenerator:not(.sc_igenerator_inited)' ).each( function() {

			var $sc = jQuery( this ).addClass( 'sc_igenerator_inited' ),
				$form = $sc.find( '.sc_igenerator_form' ),
				$prompt = $sc.find( '.sc_igenerator_form_field_prompt_text' ),
				$button = $sc.find( '.sc_igenerator_form_field_prompt_button' ),
				$preview = $sc.find( '.sc_igenerator_images' );

			$sc.find( '.sc_igenerator_form_field_tags_item' ).on( 'click', function(e) {
				e.preventDefault();
				$prompt.val( jQuery( this ).data( 'tag-prompt' ) ).trigger( 'change' );
				return false;
			} );

			$prompt.on( 'change keyup', function(e) {
				$button.toggleClass( 'sc_igenerator_form_field_prompt_button_disabled', $prompt.val() == '' );
			} )
			.trigger( 'change' );

			$button.on( 'click', function(e) {
				e.preventDefault();
				var prompt = $prompt.val(),
					settings = $form.data( 'igenerator-settings' );

				if ( ! prompt ) {
					return;
				}

				$form.addClass( 'sc_igenerator_form_loading' );

				// Save a number of requests to the client storage
				var count = trx_addons_get_cookie( 'trx_addons_ai_helper_igenerator_count' ) || 0,
					limit = 60 * 60 * 1000 * 1,	// 1 hour
					expired = limit - ( new Date().getTime() % limit );

				trx_addons_set_cookie( 'trx_addons_ai_helper_igenerator_count', ++count, expired );

				// Send request via AJAX
				jQuery.post( TRX_ADDONS_STORAGE['ajax_url'], {
					nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
					action: 'trx_addons_ai_helper_igenerator',
					settings: settings,
					prompt: prompt,
					count: count
				}, function( response ) {
					// Prepare response
					var rez = {};
					if ( response == '' || response == 0 ) {
						rez = { error: TRX_ADDONS_STORAGE['msg_ai_helper_error'] };
					} else if ( typeof response == 'string' ) {
						try {
							rez = JSON.parse( response );
						} catch (e) {
							rez = { error: TRX_ADDONS_STORAGE['msg_ai_helper_error'] };
							console.log( response );
						}
					} else {
						rez = response;
					}

					$form.removeClass( 'sc_igenerator_form_loading' );

					// Show images
					if ( ! rez.error ) {
						if ( rez.data.images.length > 0 ) {
							var html = '<div class="sc_igenerator_columns_wrap sc_item_columns '
											+ TRX_ADDONS_STORAGE['columns_wrap_class']
											+ ' columns_padding_bottom'
											+ ( rez.data.columns >= rez.data.number ? ' ' + TRX_ADDONS_STORAGE['columns_in_single_row_class'] : '' )
											+ '">';
							for ( var i = 0; i < rez.data.images.length; i++ ) {
								html += '<div class="' + trx_addons_get_column_class( 1, rez.data.columns, rez.data.columns_tablet, rez.data.columns_mobile ) + '">'
											+ '<img src="' + rez.data.images[i].url + '" alt="">'
										+ '</div>';
							}
							html += '</div>';
							$preview.html( html ).show();
							if ( rez.data.message ) {
								$form.find( '.sc_igenerator_message' ).html( rez.data.message ).addClass( 'sc_igenerator_message_show' );
								setTimeout( function() {
									$form.find( '.sc_igenerator_message' ).removeClass( 'sc_igenerator_message_show' );
								}, trx_addons_apply_filters( 'trx_addons_filter_sc_igenerator_message_timeout', 8000 ) );
							}
						}
					} else {
						alert( rez.error );
					}
				} );
			} );

			// Set padding for the prompt field to avoid overlapping the button
			if ( $button.css( 'position' ) == 'absolute' ) {
				var set_prompt_padding = ( function() {
					$prompt.css( 'padding-right', ( $button.outerWidth() + 10 ) + 'px' );
				} )();
				$window.on( 'resize', set_prompt_padding );
			}

		} );

	} );

} );