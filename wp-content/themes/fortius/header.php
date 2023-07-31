<?php
/**
 * The Header: Logo and main menu
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( fortius_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'fortius_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'fortius_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('fortius_action_body_wrap_attributes'); ?>>

		<?php do_action( 'fortius_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'fortius_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('fortius_action_page_wrap_attributes'); ?>>

			<?php do_action( 'fortius_action_page_wrap_start' ); ?>

			<?php
			$fortius_full_post_loading = ( fortius_is_singular( 'post' ) || fortius_is_singular( 'attachment' ) ) && fortius_get_value_gp( 'action' ) == 'full_post_loading';
			$fortius_prev_post_loading = ( fortius_is_singular( 'post' ) || fortius_is_singular( 'attachment' ) ) && fortius_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $fortius_full_post_loading && ! $fortius_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="fortius_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to content", 'fortius' ); ?></a>
				<?php if ( fortius_sidebar_present() ) { ?>
				<a class="fortius_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to sidebar", 'fortius' ); ?></a>
				<?php } ?>
				<a class="fortius_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to footer", 'fortius' ); ?></a>

				<?php
				do_action( 'fortius_action_before_header' );

				// Header
				$fortius_header_type = fortius_get_theme_option( 'header_type' );
				if ( 'custom' == $fortius_header_type && ! fortius_is_layouts_available() ) {
					$fortius_header_type = 'default';
				}
				get_template_part( apply_filters( 'fortius_filter_get_template_part', "templates/header-" . sanitize_file_name( $fortius_header_type ) ) );

				// Side menu
				if ( in_array( fortius_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'fortius_action_after_header' );

			}
			?>

			<?php do_action( 'fortius_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( fortius_is_off( fortius_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $fortius_header_type ) ) {
						$fortius_header_type = fortius_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $fortius_header_type && fortius_is_layouts_available() ) {
						$fortius_header_id = fortius_get_custom_header_id();
						if ( $fortius_header_id > 0 ) {
							$fortius_header_meta = fortius_get_custom_layout_meta( $fortius_header_id );
							if ( ! empty( $fortius_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$fortius_footer_type = fortius_get_theme_option( 'footer_type' );
					if ( 'custom' == $fortius_footer_type && fortius_is_layouts_available() ) {
						$fortius_footer_id = fortius_get_custom_footer_id();
						if ( $fortius_footer_id ) {
							$fortius_footer_meta = fortius_get_custom_layout_meta( $fortius_footer_id );
							if ( ! empty( $fortius_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'fortius_action_page_content_wrap_class', $fortius_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'fortius_filter_is_prev_post_loading', $fortius_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( fortius_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'fortius_action_page_content_wrap_data', $fortius_prev_post_loading );
			?>>
				<?php
				do_action( 'fortius_action_page_content_wrap', $fortius_full_post_loading || $fortius_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'fortius_filter_single_post_header', fortius_is_singular( 'post' ) || fortius_is_singular( 'attachment' ) ) ) {
					if ( $fortius_prev_post_loading ) {
						if ( fortius_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'fortius_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$fortius_path = apply_filters( 'fortius_filter_get_template_part', 'templates/single-styles/' . fortius_get_theme_option( 'single_style' ) );
					if ( fortius_get_file_dir( $fortius_path . '.php' ) != '' ) {
						get_template_part( $fortius_path );
					}
				}

				// Widgets area above page
				$fortius_body_style   = fortius_get_theme_option( 'body_style' );
				$fortius_widgets_name = fortius_get_theme_option( 'widgets_above_page' );
				$fortius_show_widgets = ! fortius_is_off( $fortius_widgets_name ) && is_active_sidebar( $fortius_widgets_name );
				if ( $fortius_show_widgets ) {
					if ( 'fullscreen' != $fortius_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					fortius_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $fortius_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'fortius_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $fortius_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'fortius_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'fortius_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="fortius_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( fortius_is_singular( 'post' ) || fortius_is_singular( 'attachment' ) )
							&& $fortius_prev_post_loading 
							&& fortius_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'fortius_action_between_posts' );
						}

						// Widgets area above content
						fortius_create_widgets_area( 'widgets_above_content' );

						do_action( 'fortius_action_page_content_start_text' );
