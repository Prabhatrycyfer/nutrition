<?php
/**
 * The template to display the socials in the footer
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.10
 */


// Socials
if ( fortius_is_on( fortius_get_theme_option( 'socials_in_footer' ) ) ) {
	$fortius_output = fortius_get_socials_links();
	if ( '' != $fortius_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php fortius_show_layout( $fortius_output ); ?>
			</div>
		</div>
		<?php
	}
}
