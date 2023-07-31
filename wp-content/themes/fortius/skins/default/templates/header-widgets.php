<?php
/**
 * The template to display the widgets area in the header
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

// Header sidebar
$fortius_header_name    = fortius_get_theme_option( 'header_widgets' );
$fortius_header_present = ! fortius_is_off( $fortius_header_name ) && is_active_sidebar( $fortius_header_name );
if ( $fortius_header_present ) {
	fortius_storage_set( 'current_sidebar', 'header' );
	$fortius_header_wide = fortius_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $fortius_header_name ) ) {
		dynamic_sidebar( $fortius_header_name );
	}
	$fortius_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $fortius_widgets_output ) ) {
		$fortius_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $fortius_widgets_output );
		$fortius_need_columns   = strpos( $fortius_widgets_output, 'columns_wrap' ) === false;
		if ( $fortius_need_columns ) {
			$fortius_columns = max( 0, (int) fortius_get_theme_option( 'header_columns' ) );
			if ( 0 == $fortius_columns ) {
				$fortius_columns = min( 6, max( 1, fortius_tags_count( $fortius_widgets_output, 'aside' ) ) );
			}
			if ( $fortius_columns > 1 ) {
				$fortius_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $fortius_columns ) . ' widget', $fortius_widgets_output );
			} else {
				$fortius_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $fortius_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'fortius_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $fortius_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $fortius_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'fortius_action_before_sidebar', 'header' );
				fortius_show_layout( $fortius_widgets_output );
				do_action( 'fortius_action_after_sidebar', 'header' );
				if ( $fortius_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $fortius_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'fortius_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
