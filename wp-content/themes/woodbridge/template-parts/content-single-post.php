<?php
/**
 * The template used for displaying content single post
 *
 * @package WordPress
 * @subpackage woodbridge
 * @since 1.0
 * @version 1.0
 */
?>

	content single post

	<?php while(have_posts()) : the_post();
		the_title();
		the_content();
	endwhile;
