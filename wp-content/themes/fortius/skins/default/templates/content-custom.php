<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.50
 */

$fortius_template_args = get_query_var( 'fortius_template_args' );
if ( is_array( $fortius_template_args ) ) {
	$fortius_columns    = empty( $fortius_template_args['columns'] ) ? 2 : max( 1, $fortius_template_args['columns'] );
	$fortius_blog_style = array( $fortius_template_args['type'], $fortius_columns );
} else {
	$fortius_blog_style = explode( '_', fortius_get_theme_option( 'blog_style' ) );
	$fortius_columns    = empty( $fortius_blog_style[1] ) ? 2 : max( 1, $fortius_blog_style[1] );
}
$fortius_blog_id       = fortius_get_custom_blog_id( join( '_', $fortius_blog_style ) );
$fortius_blog_style[0] = str_replace( 'blog-custom-', '', $fortius_blog_style[0] );
$fortius_expanded      = ! fortius_sidebar_present() && fortius_get_theme_option( 'expand_content' ) == 'expand';
$fortius_components    = ! empty( $fortius_template_args['meta_parts'] )
							? ( is_array( $fortius_template_args['meta_parts'] )
								? join( ',', $fortius_template_args['meta_parts'] )
								: $fortius_template_args['meta_parts']
								)
							: fortius_array_get_keys_by_value( fortius_get_theme_option( 'meta_parts' ) );
$fortius_post_format   = get_post_format();
$fortius_post_format   = empty( $fortius_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fortius_post_format );

$fortius_blog_meta     = fortius_get_custom_layout_meta( $fortius_blog_id );
$fortius_custom_style  = ! empty( $fortius_blog_meta['scripts_required'] ) ? $fortius_blog_meta['scripts_required'] : 'none';

if ( ! empty( $fortius_template_args['slider'] ) || $fortius_columns > 1 || ! fortius_is_off( $fortius_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $fortius_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( fortius_is_off( $fortius_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $fortius_custom_style ) ) . "-1_{$fortius_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $fortius_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $fortius_columns )
					. ' post_layout_' . esc_attr( $fortius_blog_style[0] )
					. ' post_layout_' . esc_attr( $fortius_blog_style[0] ) . '_' . esc_attr( $fortius_columns )
					. ( ! fortius_is_off( $fortius_custom_style )
						? ' post_layout_' . esc_attr( $fortius_custom_style )
							. ' post_layout_' . esc_attr( $fortius_custom_style ) . '_' . esc_attr( $fortius_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'fortius_action_show_layout', $fortius_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $fortius_template_args['slider'] ) || $fortius_columns > 1 || ! fortius_is_off( $fortius_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
