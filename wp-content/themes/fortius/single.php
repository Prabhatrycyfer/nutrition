<?php
/**
 * The template to display single post
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

// Full post loading
$full_post_loading          = fortius_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = fortius_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = fortius_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$fortius_related_position   = fortius_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$fortius_posts_navigation   = fortius_get_theme_option( 'posts_navigation' );
$fortius_prev_post          = false;
$fortius_prev_post_same_cat = fortius_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( fortius_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	fortius_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'fortius_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $fortius_posts_navigation ) {
		$fortius_prev_post = get_previous_post( $fortius_prev_post_same_cat );  // Get post from same category
		if ( ! $fortius_prev_post && $fortius_prev_post_same_cat ) {
			$fortius_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $fortius_prev_post ) {
			$fortius_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $fortius_prev_post ) ) {
		fortius_sc_layouts_showed( 'featured', false );
		fortius_sc_layouts_showed( 'title', false );
		fortius_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $fortius_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/content', 'single-' . fortius_get_theme_option( 'single_style' ) ), 'single-' . fortius_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $fortius_related_position, 'inside' ) === 0 ) {
		$fortius_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'fortius_action_related_posts' );
		$fortius_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $fortius_related_content ) ) {
			$fortius_related_position_inside = max( 0, min( 9, fortius_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $fortius_related_position_inside ) {
				$fortius_related_position_inside = mt_rand( 1, 9 );
			}

			$fortius_p_number         = 0;
			$fortius_related_inserted = false;
			$fortius_in_block         = false;
			$fortius_content_start    = strpos( $fortius_content, '<div class="post_content' );
			$fortius_content_end      = strrpos( $fortius_content, '</div>' );

			for ( $i = max( 0, $fortius_content_start ); $i < min( strlen( $fortius_content ) - 3, $fortius_content_end ); $i++ ) {
				if ( $fortius_content[ $i ] != '<' ) {
					continue;
				}
				if ( $fortius_in_block ) {
					if ( strtolower( substr( $fortius_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$fortius_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $fortius_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $fortius_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$fortius_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $fortius_content[ $i + 1 ] && in_array( $fortius_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$fortius_p_number++;
					if ( $fortius_related_position_inside == $fortius_p_number ) {
						$fortius_related_inserted = true;
						$fortius_content = ( $i > 0 ? substr( $fortius_content, 0, $i ) : '' )
											. $fortius_related_content
											. substr( $fortius_content, $i );
					}
				}
			}
			if ( ! $fortius_related_inserted ) {
				if ( $fortius_content_end > 0 ) {
					$fortius_content = substr( $fortius_content, 0, $fortius_content_end ) . $fortius_related_content . substr( $fortius_content, $fortius_content_end );
				} else {
					$fortius_content .= $fortius_related_content;
				}
			}
		}

		fortius_show_layout( $fortius_content );
	}

	// Comments
	do_action( 'fortius_action_before_comments' );
	comments_template();
	do_action( 'fortius_action_after_comments' );

	// Related posts
	if ( 'below_content' == $fortius_related_position
		&& ( 'scroll' != $fortius_posts_navigation || fortius_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || fortius_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'fortius_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $fortius_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $fortius_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $fortius_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $fortius_prev_post ) ); ?>"
			<?php do_action( 'fortius_action_nav_links_single_scroll_data', $fortius_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
