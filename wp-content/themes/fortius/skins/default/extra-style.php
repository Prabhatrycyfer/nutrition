<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'fortius_cf7_get_css' ) ) {
	add_filter( 'fortius_filter_get_css', 'fortius_cf7_get_css', 10, 2 );
	function fortius_cf7_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

			.woocommerce div.product p.price ins {
				{$fonts['h5_font-family']}
			}

CSS;
		}

		return $css;
	}
}
