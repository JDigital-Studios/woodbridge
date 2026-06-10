<?php
/**
 * Register Wine Post Type
 */

function woodbridge_register_wine_post_type() {
	$labels = [
		'name'                  => _x('Wines', 'Post Type General Name', 'woodbridge'),
		'singular_name'         => _x('Wine', 'Post Type Singular Name', 'woodbridge'),
		'menu_name'             => __('Wines', 'woodbridge'),
		'name_admin_bar'        => __('Wine', 'woodbridge'),
		'archives'              => __('Wine Archives', 'woodbridge'),
		'attributes'            => __('Wine Attributes', 'woodbridge'),
		'parent_item_colon'     => __('Parent Wine:', 'woodbridge'),
		'all_items'             => __('All Wines', 'woodbridge'),
		'add_new_item'          => __('Add New Wine', 'woodbridge'),
		'add_new'               => __('Add New', 'woodbridge'),
		'new_item'              => __('New Wine', 'woodbridge'),
		'edit_item'             => __('Edit Wine', 'woodbridge'),
		'update_item'           => __('Update Wine', 'woodbridge'),
		'view_item'             => __('View Wine', 'woodbridge'),
		'view_items'            => __('View Wines', 'woodbridge'),
		'search_items'          => __('Search Wine', 'woodbridge'),
		'not_found'             => __('Not found', 'woodbridge'),
		'not_found_in_trash'    => __('Not found in Trash', 'woodbridge'),
		'featured_image'        => __('Wine Image', 'woodbridge'),
		'set_featured_image'    => __('Set recipe image', 'woodbridge'),
		'remove_featured_image' => __('Remove recipe image', 'woodbridge'),
		'use_featured_image'    => __('Use as recipe image', 'woodbridge'),
		'insert_into_item'      => __('Insert into recipe', 'woodbridge'),
		'uploaded_to_this_item' => __('Uploaded to this recipe', 'woodbridge'),
		'items_list'            => __('Wines list', 'woodbridge'),
		'items_list_navigation' => __('Wines list navigation', 'woodbridge'),
		'filter_items_list'     => __('Filter recipes list', 'woodbridge'),
	];

	$args = [
		'label'                 => __('Wine', 'woodbridge'),
		'description'           => __('Wine posts', 'woodbridge'),
		'labels'                => $labels,
		'supports'              => ['title'],
		'taxonomies'            => ['wine_category'],
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-admin-page',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'  => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true, // Enable Gutenberg editor
		'rest_base'             => 'wines',
	];

	register_post_type('wine', $args);
}
add_action('init', 'woodbridge_register_wine_post_type', 0);


/**
 * Register Wine Categories Taxonomy
 */
function woodbridge_register_wine_categories() {
	$labels = [
		'name'                       => _x('Wine Categories', 'Taxonomy General Name', 'woodbridge'),
		'singular_name'              => _x('Wine Category', 'Taxonomy Singular Name', 'woodbridge'),
		'menu_name'                  => __('Categories', 'woodbridge'),
		'all_items'                  => __('All Categories', 'woodbridge'),
		'parent_item'                => __('Parent Category', 'woodbridge'),
		'parent_item_colon'          => __('Parent Category:', 'woodbridge'),
		'new_item_name'              => __('New Category Name', 'woodbridge'),
		'add_new_item'               => __('Add New Category', 'woodbridge'),
		'edit_item'                  => __('Edit Category', 'woodbridge'),
		'update_item'                => __('Update Category', 'woodbridge'),
		'view_item'                  => __('View Category', 'woodbridge'),
		'separate_items_with_commas' => __('Separate categories with commas', 'woodbridge'),
		'add_or_remove_items'        => __('Add or remove categories', 'woodbridge'),
		'choose_from_most_used'      => __('Choose from the most used', 'woodbridge'),
		'popular_items'              => __('Popular Categories', 'woodbridge'),
		'search_items'               => __('Search Categories', 'woodbridge'),
		'not_found'                  => __('Not Found', 'woodbridge'),
		'no_terms'                  => __('No categories', 'woodbridge'),
		'items_list'                 => __('Categories list', 'woodbridge'),
		'items_list_navigation'      => __('Categories list navigation', 'woodbridge'),
	];

	$args = [
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true, // Enable Gutenberg support
		'rewrite'                    => [
			'slug' => 'wine-category',
			'with_front' => false,
		],
	];

	register_taxonomy('wine_category', ['wine'], $args);
}
add_action('init', 'woodbridge_register_wine_categories', 0);
