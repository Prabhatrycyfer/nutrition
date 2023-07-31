<?php
/**
 * The template to display default site header
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

$fortius_header_css   = '';
$fortius_header_image = get_header_image();
$fortius_header_video = fortius_get_header_video();
if ( ! empty( $fortius_header_image ) && fortius_trx_addons_featured_image_override( is_singular() || fortius_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$fortius_header_image = fortius_get_current_mode_image( $fortius_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $fortius_header_image ) || ! empty( $fortius_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( fortius_is_on( fortius_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
