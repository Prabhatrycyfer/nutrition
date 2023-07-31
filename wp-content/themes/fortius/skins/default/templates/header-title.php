<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

// Page (category, tag, archive, author) title

if ( fortius_need_page_title() ) {
	fortius_sc_layouts_showed( 'title', true );
	fortius_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								fortius_show_post_meta(
									apply_filters(
										'fortius_filter_post_meta_args', array(
											'components' => join( ',', fortius_array_get_keys_by_value( fortius_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', fortius_array_get_keys_by_value( fortius_get_theme_option( 'counters' ) ) ),
											'seo'        => fortius_is_on( fortius_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$fortius_blog_title           = fortius_get_blog_title();
							$fortius_blog_title_text      = '';
							$fortius_blog_title_class     = '';
							$fortius_blog_title_link      = '';
							$fortius_blog_title_link_text = '';
							if ( is_array( $fortius_blog_title ) ) {
								$fortius_blog_title_text      = $fortius_blog_title['text'];
								$fortius_blog_title_class     = ! empty( $fortius_blog_title['class'] ) ? ' ' . $fortius_blog_title['class'] : '';
								$fortius_blog_title_link      = ! empty( $fortius_blog_title['link'] ) ? $fortius_blog_title['link'] : '';
								$fortius_blog_title_link_text = ! empty( $fortius_blog_title['link_text'] ) ? $fortius_blog_title['link_text'] : '';
							} else {
								$fortius_blog_title_text = $fortius_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $fortius_blog_title_class ); ?>">
								<?php
								$fortius_top_icon = fortius_get_term_image_small();
								if ( ! empty( $fortius_top_icon ) ) {
									$fortius_attr = fortius_getimagesize( $fortius_top_icon );
									?>
									<img src="<?php echo esc_url( $fortius_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'fortius' ); ?>"
										<?php
										if ( ! empty( $fortius_attr[3] ) ) {
											fortius_show_layout( $fortius_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $fortius_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $fortius_blog_title_link ) && ! empty( $fortius_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $fortius_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $fortius_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'fortius_action_breadcrumbs' );
						$fortius_breadcrumbs = ob_get_contents();
						ob_end_clean();
						fortius_show_layout( $fortius_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
