<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

							do_action( 'fortius_action_page_content_end_text' );
							
							// Widgets area below the content
							fortius_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'fortius_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'fortius_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'fortius_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'fortius_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$fortius_body_style = fortius_get_theme_option( 'body_style' );
					$fortius_widgets_name = fortius_get_theme_option( 'widgets_below_page' );
					$fortius_show_widgets = ! fortius_is_off( $fortius_widgets_name ) && is_active_sidebar( $fortius_widgets_name );
					$fortius_show_related = fortius_is_single() && fortius_get_theme_option( 'related_position' ) == 'below_page';
					if ( $fortius_show_widgets || $fortius_show_related ) {
						if ( 'fullscreen' != $fortius_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $fortius_show_related ) {
							do_action( 'fortius_action_related_posts' );
						}

						// Widgets area below page content
						if ( $fortius_show_widgets ) {
							fortius_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $fortius_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'fortius_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'fortius_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! fortius_is_singular( 'post' ) && ! fortius_is_singular( 'attachment' ) ) || ! in_array ( fortius_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="fortius_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'fortius_action_before_footer' );

				// Footer
				$fortius_footer_type = fortius_get_theme_option( 'footer_type' );
				if ( 'custom' == $fortius_footer_type && ! fortius_is_layouts_available() ) {
					$fortius_footer_type = 'default';
				}
				get_template_part( apply_filters( 'fortius_filter_get_template_part', "templates/footer-" . sanitize_file_name( $fortius_footer_type ) ) );

				do_action( 'fortius_action_after_footer' );

			}
			?>

			<?php do_action( 'fortius_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'fortius_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'fortius_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>