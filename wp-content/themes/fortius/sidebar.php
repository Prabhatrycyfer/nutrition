<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

if ( fortius_sidebar_present() ) {
	
	$fortius_sidebar_type = fortius_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $fortius_sidebar_type && ! fortius_is_layouts_available() ) {
		$fortius_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $fortius_sidebar_type ) {
		// Default sidebar with widgets
		$fortius_sidebar_name = fortius_get_theme_option( 'sidebar_widgets' );
		fortius_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $fortius_sidebar_name ) ) {
			dynamic_sidebar( $fortius_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$fortius_sidebar_id = fortius_get_custom_sidebar_id();
		do_action( 'fortius_action_show_layout', $fortius_sidebar_id );
	}
	$fortius_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $fortius_out ) ) {
		$fortius_sidebar_position    = fortius_get_theme_option( 'sidebar_position' );
		$fortius_sidebar_position_ss = fortius_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $fortius_sidebar_position );
			echo ' sidebar_' . esc_attr( $fortius_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $fortius_sidebar_type );

			$fortius_sidebar_scheme = apply_filters( 'fortius_filter_sidebar_scheme', fortius_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $fortius_sidebar_scheme ) && ! fortius_is_inherit( $fortius_sidebar_scheme ) && 'custom' != $fortius_sidebar_type ) {
				echo ' scheme_' . esc_attr( $fortius_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="fortius_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'fortius_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $fortius_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$fortius_title = apply_filters( 'fortius_filter_sidebar_control_title', 'float' == $fortius_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'fortius' ) : '' );
				$fortius_text  = apply_filters( 'fortius_filter_sidebar_control_text', 'above' == $fortius_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'fortius' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $fortius_title ); ?>"><?php echo esc_html( $fortius_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'fortius_action_before_sidebar', 'sidebar' );
				fortius_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $fortius_out ) );
				do_action( 'fortius_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'fortius_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
