<?php
/**
 * The template to display the 404 page
 *
 * @package FORTIUS
 * @since FORTIUS 1.0
 */

get_header();

get_template_part( apply_filters( 'fortius_filter_get_template_part', 'templates/content', '404' ), '404' );

get_footer();
