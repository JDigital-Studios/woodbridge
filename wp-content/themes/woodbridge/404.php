<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage woodbridge
 * @since 1.0
 * @version 1.0
 */

get_header();

// Pull the "Shop Now" destination from the main nav menu so this CTA stays in
// sync with the header button. Falls back to the home page if not found.
$shop_url = home_url('/');
$locations = get_nav_menu_locations();
if (isset($locations['main'])) {
	$menu_items = wp_get_nav_menu_items($locations['main']);
	if ($menu_items) {
		foreach ($menu_items as $menu_item) {
			if (stripos($menu_item->title, 'shop') !== false) {
				$shop_url = $menu_item->url;
				break;
			}
		}
	}
}

$bg_image = get_template_directory_uri() . '/dist/images/404-bg.png';
?>

	<section class="error-404 relative flex items-center justify-center min-h-[calc(100vh_-_140px)] bg-[#FDF8F4] bg-no-repeat bg-contain bg-center" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
		<div class="container max-w-[860px] text-center py-20">
			<h1 class="font-title text-35 leading-[40px] tracking-[1.4px] uppercase font-medium text-black mb-4">404 Page Not Found</h1>
			<p class="text-lg md:text-xl text-black mb-8">Find Woodbridge Wines in a store near you.</p>
			<a href="<?php echo esc_url($shop_url); ?>" class="btn">Shop Now</a>
		</div>
	</section>

<?php get_footer();
