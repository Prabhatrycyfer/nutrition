<?php
/**
 * The Portfolio template to display the content
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

$fortius_post_format = get_post_format();
$fortius_post_format = empty( $fortius_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fortius_post_format );

?><div class="
<?php
if ( ! empty( $fortius_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( fortius_is_blog_style_use_masonry( $fortius_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $fortius_columns ) : esc_attr( $fortius_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $fortius_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $fortius_columns )
		. ( 'portfolio' != $fortius_blog_style[0] ? ' ' . esc_attr( $fortius_blog_style[0] )  . '_' . esc_attr( $fortius_columns ) : '' )
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

	$fortius_hover   = ! empty( $fortius_template_args['hover'] ) && ! fortius_is_inherit( $fortius_template_args['hover'] )
								? $fortius_template_args['hover']
								: fortius_get_theme_option( 'image_hover' );

	if ( 'dots' == $fortius_hover ) {
		$fortius_post_link = empty( $fortius_template_args['no_links'] )
								? ( ! empty( $fortius_template_args['link'] )
									? $fortius_template_args['link']
									: get_permalink()
									)
								: '';
		$fortius_target    = ! empty( $fortius_post_link ) && false === strpos( $fortius_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$fortius_components = ! empty( $fortius_template_args['meta_parts'] )
							? ( is_array( $fortius_template_args['meta_parts'] )
								? $fortius_template_args['meta_parts']
								: explode( ',', $fortius_template_args['meta_parts'] )
								)
							: fortius_array_get_keys_by_value( fortius_get_theme_option( 'meta_parts' ) );

	// Featured image
	fortius_show_post_featured( apply_filters( 'fortius_filter_args_featured',
        array(
			'hover'         => $fortius_hover,
			'no_links'      => ! empty( $fortius_template_args['no_links'] ),
			'thumb_size'    => ! empty( $fortius_template_args['thumb_size'] )
								? $fortius_template_args['thumb_size']
								: fortius_get_thumb_size(
									fortius_is_blog_style_use_masonry( $fortius_blog_style[0] )
										? (	strpos( fortius_get_theme_option( 'body_style' ), 'full' ) !== false || $fortius_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( fortius_get_theme_option( 'body_style' ), 'full' ) !== false || $fortius_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => fortius_is_blog_style_use_masonry( $fortius_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $fortius_components,
			'class'         => 'dots' == $fortius_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $fortius_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $fortius_post_link )
												? '<a href="' . esc_url( $fortius_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $fortius_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $fortius_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $fortius_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!