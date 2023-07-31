<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.10
 */

// Footer sidebar
$fortius_footer_name    = fortius_get_theme_option( 'footer_widgets' );
$fortius_footer_present = ! fortius_is_off( $fortius_footer_name ) && is_active_sidebar( $fortius_footer_name );
if ( $fortius_footer_present ) {
	fortius_storage_set( 'current_sidebar', 'footer' );
	$fortius_footer_wide = fortius_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $fortius_footer_name ) ) {
		dynamic_sidebar( $fortius_footer_name );
	}
	$fortius_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $fortius_out ) ) {
		$fortius_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $fortius_out );
		$fortius_need_columns = true;   //or check: strpos($fortius_out, 'columns_wrap')===false;
		if ( $fortius_need_columns ) {
			$fortius_columns = max( 0, (int) fortius_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $fortius_columns ) {
				$fortius_columns = min( 4, max( 1, fortius_tags_count( $fortius_out, 'aside' ) ) );
			}
			if ( $fortius_columns > 1 ) {
				$fortius_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $fortius_columns ) . ' widget', $fortius_out );
			} else {
				$fortius_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $fortius_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'fortius_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $fortius_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $fortius_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'fortius_action_before_sidebar', 'footer' );
				fortius_show_layout( $fortius_out );
				do_action( 'fortius_action_after_sidebar', 'footer' );
				if ( $fortius_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $fortius_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'fortius_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
