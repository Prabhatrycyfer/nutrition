<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.06
 */

$fortius_header_css   = '';
$fortius_header_image = get_header_image();
$fortius_header_video = fortius_get_header_video();
if ( ! empty( $fortius_header_image ) && fortius_trx_addons_featured_image_override( is_singular() || fortius_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$fortius_header_image = fortius_get_current_mode_image( $fortius_header_image );
}

$fortius_header_id = fortius_get_custom_header_id();
$fortius_header_meta = get_post_meta( $fortius_header_id, 'trx_addons_options', true );
if ( ! empty( $fortius_header_meta['margin'] ) ) {
	fortius_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( fortius_prepare_css_value( $fortius_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $fortius_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $fortius_header_id ) ) ); ?>
				<?php
				echo ! empty( $fortius_header_image ) || ! empty( $fortius_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $fortius_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $fortius_header_image ) {
					echo ' ' . esc_attr( fortius_add_inline_css_class( 'background-image: url(' . esc_url( $fortius_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( fortius_is_on( fortius_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight fortius-full-height';
				}
				$fortius_header_scheme = fortius_get_theme_option( 'header_scheme' );
				if ( ! empty( $fortius_header_scheme ) && ! fortius_is_inherit( $fortius_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $fortius_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $fortius_header_video ) ) {
		get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'fortius_action_show_layout', $fortius_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
