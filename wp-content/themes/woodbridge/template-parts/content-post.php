<?php
/**
 * The template used for displaying content post
 *
 * @package WordPress
 * @subpackage woodbridge
 * @since 1.0
 * @version 1.0
 */
?>

	content post

	<?php while(have_posts()) : the_post();
		<?php the_permalink();
		the_title();
		the_excerpt();
	endwhile;
