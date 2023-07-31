<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

$fortius_template_args = get_query_var( 'fortius_template_args' );

if ( is_array( $fortius_template_args ) ) {
	$fortius_columns    = empty( $fortius_template_args['columns'] ) ? 2 : max( 1, $fortius_template_args['columns'] );
	$fortius_blog_style = array( $fortius_template_args['type'], $fortius_columns );
    $fortius_columns_class = fortius_get_column_class( 1, $fortius_columns, ! empty( $fortius_template_args['columns_tablet']) ? $fortius_template_args['columns_tablet'] : '', ! empty($fortius_template_args['columns_mobile']) ? $fortius_template_args['columns_mobile'] : '' );
} else {
	$fortius_blog_style = explode( '_', fortius_get_theme_option( 'blog_style' ) );
	$fortius_columns    = empty( $fortius_blog_style[1] ) ? 2 : max( 1, $fortius_blog_style[1] );
    $fortius_columns_class = fortius_get_column_class( 1, $fortius_columns );
}
$fortius_expanded   = ! fortius_sidebar_present() && fortius_get_theme_option( 'expand_content' ) == 'expand';

$fortius_post_format = get_post_format();
$fortius_post_format = empty( $fortius_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fortius_post_format );

?><div class="<?php
	if ( ! empty( $fortius_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( fortius_is_blog_style_use_masonry( $fortius_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $fortius_columns ) : esc_attr( $fortius_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $fortius_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $fortius_columns )
				. ' post_layout_' . esc_attr( $fortius_blog_style[0] )
				. ' post_layout_' . esc_attr( $fortius_blog_style[0] ) . '_' . esc_attr( $fortius_columns )
	);
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
								: explode( ',', $fortius_template_args['meta_parts'] )
								)
							: fortius_array_get_keys_by_value( fortius_get_theme_option( 'meta_parts' ) );

	fortius_show_post_featured( apply_filters( 'fortius_filter_args_featured',
		array(
			'thumb_size' => ! empty( $fortius_template_args['thumb_size'] )
				? $fortius_template_args['thumb_size']
				: fortius_get_thumb_size(
				'classic' == $fortius_blog_style[0]
						? ( strpos( fortius_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $fortius_columns > 2 ? 'big' : 'huge' )
								: ( $fortius_columns > 2
									? ( $fortius_expanded ? 'square' : 'square' )
									: ($fortius_columns > 1 ? 'square' : ( $fortius_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( fortius_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $fortius_columns > 2 ? 'masonry-big' : 'full' )
								: ($fortius_columns === 1 ? ( $fortius_expanded ? 'huge' : 'big' ) : ( $fortius_columns <= 2 && $fortius_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $fortius_hover,
			'meta_parts' => $fortius_components,
			'no_links'   => ! empty( $fortius_template_args['no_links'] ),
        ),
        'content-classic',
        $fortius_template_args
    ) );

	// Title and post meta
	$fortius_show_title = get_the_title() != '';
	$fortius_show_meta  = count( $fortius_components ) > 0 && ! in_array( $fortius_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $fortius_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'fortius_filter_show_blog_meta', $fortius_show_meta, $fortius_components, 'classic' ) ) {
				if ( count( $fortius_components ) > 0 ) {
					do_action( 'fortius_action_before_post_meta' );
					fortius_show_post_meta(
						apply_filters(
							'fortius_filter_post_meta_args', array(
							'components' => join( ',', $fortius_components ),
							'seo'        => false,
							'echo'       => true,
						), $fortius_blog_style[0], $fortius_columns
						)
					);
					do_action( 'fortius_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'fortius_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'fortius_action_before_post_title' );
				if ( empty( $fortius_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'fortius_action_after_post_title' );
			}

			if( !in_array( $fortius_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'fortius_filter_show_blog_readmore', ! $fortius_show_title || ! empty( $fortius_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $fortius_template_args['no_links'] ) ) {
						do_action( 'fortius_action_before_post_readmore' );
						fortius_show_post_more_link( $fortius_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'fortius_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $fortius_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('fortius_filter_show_blog_excerpt', empty($fortius_template_args['hide_excerpt']) && fortius_get_theme_option('excerpt_length') > 0, 'classic')) {
			fortius_show_post_content($fortius_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $fortius_template_args['more_button'] )) {
			if ( empty( $fortius_template_args['no_links'] ) ) {
				do_action( 'fortius_action_before_post_readmore' );
				fortius_show_post_more_link( $fortius_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'fortius_action_after_post_readmore' );
			}
		}
		$fortius_content = ob_get_contents();
		ob_end_clean();
		fortius_show_layout($fortius_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
