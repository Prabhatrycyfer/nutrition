<?php
/**
 * The template to display default site footer
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$fortius_footer_scheme = fortius_get_theme_option( 'footer_scheme' );
if ( ! empty( $fortius_footer_scheme ) && ! fortius_is_inherit( $fortius_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fortius_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
