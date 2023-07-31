<?php
/**
 * The template to display the site logo in the footer
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.10
 */

// Logo
if ( fortius_is_on( fortius_get_theme_option( 'logo_in_footer' ) ) ) {
	$fortius_logo_image = fortius_get_logo_image( 'footer' );
	$fortius_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $fortius_logo_image['logo'] ) || ! empty( $fortius_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $fortius_logo_image['logo'] ) ) {
					$fortius_attr = fortius_getimagesize( $fortius_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $fortius_logo_image['logo'] ) . '"'
								. ( ! empty( $fortius_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $fortius_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'fortius' ) . '"'
								. ( ! empty( $fortius_attr[3] ) ? ' ' . wp_kses_data( $fortius_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $fortius_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $fortius_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
