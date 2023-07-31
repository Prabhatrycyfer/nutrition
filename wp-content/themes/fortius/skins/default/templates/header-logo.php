<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

$fortius_args = get_query_var( 'fortius_logo_args' );

// Site logo
$fortius_logo_type   = isset( $fortius_args['type'] ) ? $fortius_args['type'] : '';
$fortius_logo_image  = fortius_get_logo_image( $fortius_logo_type );
$fortius_logo_text   = fortius_is_on( fortius_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$fortius_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $fortius_logo_image['logo'] ) || ! empty( $fortius_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $fortius_logo_image['logo'] ) ) {
			if ( empty( $fortius_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($fortius_logo_image['logo']) && (int) $fortius_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$fortius_attr = fortius_getimagesize( $fortius_logo_image['logo'] );
				echo '<img src="' . esc_url( $fortius_logo_image['logo'] ) . '"'
						. ( ! empty( $fortius_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $fortius_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $fortius_logo_text ) . '"'
						. ( ! empty( $fortius_attr[3] ) ? ' ' . wp_kses_data( $fortius_attr[3] ) : '' )
						. '>';
			}
		} else {
			fortius_show_layout( fortius_prepare_macros( $fortius_logo_text ), '<span class="logo_text">', '</span>' );
			fortius_show_layout( fortius_prepare_macros( $fortius_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
