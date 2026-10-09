<?php

/**
 * Pear Commerce store locator and shoppable PDP.
 *
 * Shop Now keeps the [mio-mikmak] shortcode in the WordPress editor.
 * The callback below prints the Pear mount instead. Do not delete the shortcode from the database.
 */

/**
 * Pages that should show Pear instead of MikMak.
 */
function woodbridge_is_pear_page()
{
	return is_page('shop-now') || is_singular('wine');
}

/**
 * Stop the sitewide MikMak tag on pages that render Pear.
 */
function woodbridge_remove_mikmak_script()
{
	if (!woodbridge_is_pear_page()) {
		return;
	}

	remove_action('wp_head', 'mio_mikmak_header_script');
}
add_action('wp', 'woodbridge_remove_mikmak_script');

/**
 * Replace the old MikMak store-locator shortcode with the Pear map mount.
 * The shortcode stays in the Shop Now editor content, inside the existing
 * .container and .entry wrappers.
 */
function woodbridge_replace_mikmak_shortcode()
{
	remove_shortcode('mio-mikmak');
	add_shortcode('mio-mikmak', 'woodbridge_pear_map_shortcode');
}
add_action('init', 'woodbridge_replace_mikmak_shortcode', 20);

function woodbridge_pear_map_shortcode()
{
	return '<div id="pear-map-target"></div>';
}

/**
 * Load one Pear widget in the footer. Shop Now gets the store locator.
 * Wine singles get the bundled retailer list.
 */
function woodbridge_pear_footer_script()
{
	if (is_page('shop-now')) {
		$widget = 'product-locator';
	} elseif (is_singular('wine')) {
		$widget = 'retailer-list';
	} else {
		return;
	}

	$config = wp_json_encode([
		'vendorId' => '3064473864896868',
		'widget'   => $widget,
	]);

	$markup = '<script>(function(e){var s=document.createElement("script");s.type="text/javascript";s.src="https://offers.pearcommerce.com/js/sdk.js?config="+encodeURIComponent(JSON.stringify(e));document.head.appendChild(s);})(' . $config . ');</script>';

	echo $markup;
}
add_action('wp_footer', 'woodbridge_pear_footer_script');
