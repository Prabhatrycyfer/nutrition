<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

$fortius_template_args = get_query_var( 'fortius_template_args' );
$fortius_columns = 1;
if ( is_array( $fortius_template_args ) ) {
	$fortius_columns    = empty( $fortius_template_args['columns'] ) ? 1 : max( 1, $fortius_template_args['columns'] );
	$fortius_blog_style = array( $fortius_template_args['type'], $fortius_columns );
	if ( ! empty( $fortius_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $fortius_columns > 1 ) {
	    $fortius_columns_class = fortius_get_column_class( 1, $fortius_columns, ! empty( $fortius_template_args['columns_tablet']) ? $fortius_template_args['columns_tablet'] : '', ! empty($fortius_template_args['columns_mobile']) ? $fortius_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $fortius_columns_class ); ?>">
		<?php
	}
}
$fortius_expanded    = ! fortius_sidebar_present() && fortius_get_theme_option( 'expand_content' ) == 'expand';
$fortius_post_format = get_post_format();
$fortius_post_format = empty( $fortius_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fortius_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $fortius_post_format ) );
	fortius_add_blog_animation( $fortius_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$fortius_hover      = ! empty( $fortius_template_args['hover'] ) && ! fortius_is_inherit( $fortius_template_args['hover'] )
							? $fortius_template_args['hover']
							: fortius_get_theme_option( 'image_hover' );
	$fortius_components = ! empty( $fortius_template_args['meta_parts'] )
							? ( is_array( $fortius_template_args['meta_parts'] )
								? $fortius_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $fortius_template_args['meta_parts'] ) )
								)
							: fortius_array_get_keys_by_value( fortius_get_theme_option( 'meta_parts' ) );
	fortius_show_post_featured( apply_filters( 'fortius_filter_args_featured',
		array(
			'no_links'   => ! empty( $fortius_template_args['no_links'] ),
			'hover'      => $fortius_hover,
			'meta_parts' => $fortius_components,
			'thumb_size' => ! empty( $fortius_template_args['thumb_size'] )
							? $fortius_template_args['thumb_size']
							: fortius_get_thumb_size( strpos( fortius_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $fortius_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$fortius_template_args
	) );

	// Title and post meta
	$fortius_show_title = get_the_title() != '';
	$fortius_show_meta  = count( $fortius_components ) > 0 && ! in_array( $fortius_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $fortius_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'fortius_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'fortius_action_before_post_title' );
				if ( empty( $fortius_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'fortius_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'fortius_filter_show_blog_excerpt', empty( $fortius_template_args['hide_excerpt'] ) && fortius_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'fortius_filter_show_blog_meta', $fortius_show_meta, $fortius_components, 'excerpt' ) ) {
				if ( count( $fortius_components ) > 0 ) {
					do_action( 'fortius_action_before_post_meta' );
					fortius_show_post_meta(
						apply_filters(
							'fortius_filter_post_meta_args', array(
								'components' => join( ',', $fortius_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'fortius_action_after_post_meta' );
				}
			}

			if ( fortius_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'fortius_action_before_full_post_content' );
					the_content( '' );
					do_action( 'fortius_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'fortius' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'fortius' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				fortius_show_post_content( $fortius_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'fortius_filter_show_blog_readmore',  ! isset( $fortius_template_args['more_button'] ) || ! empty( $fortius_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $fortius_template_args['no_links'] ) ) {
					do_action( 'fortius_action_before_post_readmore' );
					if ( fortius_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						fortius_show_post_more_link( $fortius_template_args, '<p>', '</p>' );
					} else {
						fortius_show_post_comments_link( $fortius_template_args, '<p>', '</p>' );
					}
					do_action( 'fortius_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $fortius_template_args ) ) {
	if ( ! empty( $fortius_template_args['slider'] ) || $fortius_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
