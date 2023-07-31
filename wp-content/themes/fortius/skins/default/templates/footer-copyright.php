<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$fortius_copyright_scheme = fortius_get_theme_option( 'copyright_scheme' );
if ( ! empty( $fortius_copyright_scheme ) && ! fortius_is_inherit( $fortius_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fortius_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$fortius_copyright = fortius_get_theme_option( 'copyright' );
			if ( ! empty( $fortius_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$fortius_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $fortius_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$fortius_copyright = fortius_prepare_macros( $fortius_copyright );
				// Display copyright
				echo wp_kses( nl2br( $fortius_copyright ), 'fortius_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
