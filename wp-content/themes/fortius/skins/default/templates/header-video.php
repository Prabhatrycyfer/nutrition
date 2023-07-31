<?php
/**
 * The template to display the background video in the header
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.14
 */
$fortius_header_video = fortius_get_header_video();
$fortius_embed_video  = '';
if ( ! empty( $fortius_header_video ) && ! fortius_is_from_uploads( $fortius_header_video ) ) {
	if ( fortius_is_youtube_url( $fortius_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $fortius_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php fortius_show_layout( fortius_get_embed_video( $fortius_header_video ) ); ?></div>
		<?php
	}
}
