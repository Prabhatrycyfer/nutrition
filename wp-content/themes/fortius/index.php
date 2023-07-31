<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

$fortius_template = apply_filters( 'fortius_filter_get_template_part', fortius_blog_archive_get_template() );

if ( ! empty( $fortius_template ) && 'index' != $fortius_template ) {

	get_template_part( $fortius_template );

} else {

	fortius_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$fortius_stickies   = is_home()
								|| ( in_array( fortius_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) fortius_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$fortius_post_type  = fortius_get_theme_option( 'post_type' );
		$fortius_args       = array(
								'blog_style'     => fortius_get_theme_option( 'blog_style' ),
								'post_type'      => $fortius_post_type,
								'taxonomy'       => fortius_get_post_type_taxonomy( $fortius_post_type ),
								'parent_cat'     => fortius_get_theme_option( 'parent_cat' ),
								'posts_per_page' => fortius_get_theme_option( 'posts_per_page' ),
								'sticky'         => fortius_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $fortius_stickies )
															&& count( $fortius_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		fortius_blog_archive_start();

		do_action( 'fortius_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'fortius_action_before_page_author' );
			get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'fortius_action_after_page_author' );
		}

		if ( fortius_get_theme_option( 'show_filters' ) ) {
			do_action( 'fortius_action_before_page_filters' );
			fortius_show_filters( $fortius_args );
			do_action( 'fortius_action_after_page_filters' );
		} else {
			do_action( 'fortius_action_before_page_posts' );
			fortius_show_posts( array_merge( $fortius_args, array( 'cat' => $fortius_args['parent_cat'] ) ) );
			do_action( 'fortius_action_after_page_posts' );
		}

		do_action( 'fortius_action_blog_archive_end' );

		fortius_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
