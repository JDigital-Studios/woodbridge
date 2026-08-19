<?php

/**
 * woodbridge functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage woodbridge
 * @since 1.0
 */

define('WOODBRIDGE_VER', '1.1.4');

/**
 * Block system constants — change these when reusing on a new theme.
 */
if (!defined('THEME_BLOCK_CATEGORY')) {
	define('THEME_BLOCK_CATEGORY', 'woodbridge');
}
if (!defined('THEME_TEXT_DOMAIN')) {
	define('THEME_TEXT_DOMAIN', 'woodbridge');
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function woodbridge_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('woodbridge');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// Add support for Block Styles.
	add_theme_support('wp-block-styles');

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for editor styles.
	add_theme_support('editor-styles');

	add_image_size('920x882', 920, 882, true);
	add_image_size('1009x880', 1009, 880, true);
	add_image_size('200x534', 200, 534, true);
	add_image_size('700x700', 700, 700, true);

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus([
		'main'	 => __('Main Menu', 'woodbridge'),
		'footer' => __('Footer Menu', 'woodbridge'),
	]);
}
add_action('after_setup_theme', 'woodbridge_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function woodbridge_widgets_init()
{
	register_sidebar([
		'name'          => __('Blog Sidebar', 'woodbridge'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'woodbridge'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	]);
}
// add_action('widgets_init', 'woodbridge_widgets_init');


/**
 * Enqueue scripts and styles.
 */
function woodbridge_scripts()
{

	// css script
	wp_enqueue_style('typekit', 'https://use.typekit.net/jrk1yom.css', [], WOODBRIDGE_VER);
	wp_enqueue_style('main', get_theme_file_uri('/dist/main.min.css'), [], WOODBRIDGE_VER);

	// js script
	wp_enqueue_style('wp-block-library');
	wp_enqueue_script('custom-scrollbar', 'https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js', ['jquery'], WOODBRIDGE_VER, true);
	wp_enqueue_script('main', get_theme_file_uri('/dist/main.min.js'), ['jquery'], WOODBRIDGE_VER, true);
}
add_action('wp_enqueue_scripts', 'woodbridge_scripts');


/**
 * Enqueue block editor assets
 */
function woodbridge_enqueue_block_editor_assets()
{
	$theme = wp_get_theme();

	// Enqueue the editor-specific stylesheet
	wp_enqueue_style('woodbridge-editor-styles', get_template_directory_uri() . '/dist/editor.css', [], $theme->get('Version'));
}
add_action('enqueue_block_editor_assets', 'woodbridge_enqueue_block_editor_assets');


/**
 * Custom filter to remove default image sizes from WordPress.
 */
function remove_default_image_sizes($sizes)
{
	unset($sizes['thumbnail']);
	unset($sizes['medium']);
	unset($sizes['medium']);
	unset($sizes['medium_large']);
	unset($sizes['large']);
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');


/**
 * Get post thumbnail alt text
 */
function get_image_alt($post_id = null)
{
	$post_id = $post_id ? $post_id : get_the_ID();
	return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
}

/**
 * Get full link
 */
function get_link_field($field = null, $classes = '')
{
	if ($field) : ?>
		<a href="<?php echo $field['url']; ?>" class="<?php echo $classes; ?>" target="<?php echo $field['target']; ?>"><?php echo $field['title']; ?></a>
	<?php
	endif;
}


/**
 * Return youtube video id for all url's
 */
function youtube_id($videoURL = false)
{
	if ($videoURL) {
		$pattern = "/^(?:https?:\\/\\/)?(?:www\\.)?(?:youtu\\.be\\/|youtube\\.com(?:\\/embed\\/|\\/v\\/|\\/vi\\/|\\/watch\\?v=|\\/\\?vi=|\\/\\?v=|\\/watch\\?vi=|\\/watch\\?.+&v=))([\\w-]{11})(?:.+)?$/mi";
		preg_match($pattern, $videoURL, $videoId);
		return $videoId[1];
	}
	return false;
}


/**
 * Return vimeo video id for all url's
 */
function vimeo_id($videoURL = false)
{
	if ($videoURL) {
		$pattern = "/(http|https)?:\/\/(www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|)(\d+)(?:|\/\?)/";
		preg_match($pattern, $videoURL, $videoId);
		return $videoId[4];
	}
	return false;
}

// Userway header script
function userway_header_script()
{
	echo '<script src="https://cdn.userway.org/widget.js" data-account="OQBfWXhU5x"></script>';
}
add_action('wp_head', 'userway_header_script');

// GTM header script
function gtm_header_script()
{
	?>
	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-PLBGCSD7');
	</script>
	<!-- End Google Tag Manager -->
<?php
}
add_action('wp_head', 'gtm_header_script');

/**
 * Option Page
 */
if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title'	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings'
	]);
}


/**
 * 
 */
function theme_block_category($categories)
{
	return array_merge(
		$categories,
		[
			[
				'slug'  => THEME_BLOCK_CATEGORY,
				'title' => __(ucwords(str_replace('-', ' ', THEME_BLOCK_CATEGORY)) . ' Blocks', THEME_TEXT_DOMAIN),
				'icon'  => 'block-default',
			],
		]
	);
}
add_filter('block_categories_all', 'theme_block_category', 10, 2);


/**
 * Load ACF Field Groups for templates and other non-block areas
 */
require get_template_directory() . '/inc/acf-field-loader.php';


/**
 * Load ACF Blocks System
 * 
 * Modern, scalable block system with auto-discovery
 * Each block is self-contained in its own directory
 */
require get_template_directory() . '/inc/blocks/load-blocks.php';


/**
 * Add Wine CPT
 */
require get_template_directory() . '/inc/post-types/wines.php';

/**
 * Add title attribute in menu
 */
add_filter('nav_menu_link_attributes', function ($atts, $item) {
	$atts['title'] = (!empty($item->post_excerpt)) ? $item->post_excerpt : $item->title;
	return $atts;
}, 10, 2);


/**
 * 301-redirect wine_category taxonomy archives to the wines page with the
 * category slug as a hash so the client-side filter activates.
 */
function woodbridge_redirect_wine_category_archives()
{
	if (!is_tax('wine_category')) return;

	$term         = get_queried_object();
	$wines_page   = home_url('/our-wines/');
	$redirect_url = ($term && !is_wp_error($term))
		? $wines_page . '#' . $term->slug
		: $wines_page;

	wp_redirect($redirect_url, 301);
	exit;
}
add_action('template_redirect', 'woodbridge_redirect_wine_category_archives');

/**
 * Remove wine_category from the WordPress XML sitemap — the taxonomy archives
 * 301-redirect, so there's no reason for search engines to crawl them.
 */
add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
	unset($taxonomies['wine_category']);
	return $taxonomies;
});

// Insert the Cookiebot footer link right after the Privacy Policy item
function woodbridge_insert_cookiebot_after_privacy( $items, $args ) {
	if ( isset( $args->theme_location ) && $args->theme_location !== 'footer' ) {
		return $items;
	}

	$cookiebot = '<li id="menu-item-woodbridge-cookiebot" class="menu-item"><a href="#" id="woodbridge-cookiebot-preferences-link">Do Not Sell or Share My Personal Information</a></li>';

	if ( preg_match( '/(<li[^>]*>.*?<a[^>]*>\s*privacy\s+policy\s*<\/a>.*?<\/li>)/is', $items, $match ) ) {
		$items = str_replace( $match[1], $match[1] . $cookiebot, $items );
	} else {
		$items .= $cookiebot;
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'woodbridge_insert_cookiebot_after_privacy', 10, 2 );
