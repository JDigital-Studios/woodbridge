<?php
/**
 * Hero Parallax Fields
 *
 * Return an array of ACF field definitions.
 * The block loader will automatically register these fields.
 */


return [
	[
		'key' => 'field_desktop_image',
		'label' => 'Desktop Image',
		'name' => 'desktop_image',
		'aria-label' => '',
		'type' => 'image',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'return_format' => 'id',
		'library' => 'all',
		'min_width' => '',
		'min_height' => '',
		'min_size' => '',
		'max_width' => '',
		'max_height' => '',
		'max_size' => '',
		'mime_types' => '',
		'allow_in_bindings' => 0,
		'preview_size' => 'thumbnail',
	],
	[
		'key' => 'field_mobile_image',
		'label' => 'Mobile Image',
		'name' => 'mobile_image',
		'aria-label' => '',
		'type' => 'image',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'return_format' => 'id',
		'library' => 'all',
		'min_width' => '',
		'min_height' => '',
		'min_size' => '',
		'max_width' => '',
		'max_height' => '',
		'max_size' => '',
		'mime_types' => '',
		'allow_in_bindings' => 0,
		'preview_size' => 'thumbnail',
	],
	[
		'key' => 'field_hero_parallax_show_logo',
		'label' => 'Show Logo',
		'name' => 'show_logo',
		'type' => 'true_false',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'message' => '',
		'default_value' => 0,
		'ui' => 1,
		'ui_on_text' => '',
		'ui_off_text' => '',
		'allow_in_bindings' => 0,
	],
];
