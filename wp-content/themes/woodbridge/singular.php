<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage 7_deadly
 * @since 1.0
 * @version 1.0
 */

get_header();

	if (have_posts()) :
		get_template_part('template-parts/content-single', get_post_type());
	endif;

get_footer();
