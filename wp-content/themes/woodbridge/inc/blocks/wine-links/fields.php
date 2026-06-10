<?php
/**
 * Wine Links Block Fields
 *
 * Return an array of ACF field definitions.
 * The block loader will automatically register these fields.
 */


return [
	[
		'key' => 'field_items_wine_links',
		'label' => 'Items',
		'name' => 'items',
		'aria-label' => '',
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'layout' => 'block',
		'pagination' => 0,
		'min' => 0,
		'max' => 0,
		'collapsed' => '',
		'button_label' => 'Add Item',
		'rows_per_page' => 20,
		'sub_fields' => [
			[
				'key' => 'field_link',
				'label' => 'Link',
				'name' => 'link',
				'aria-label' => '',
				'type' => 'link',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'return_format' => 'array',
				'allow_in_bindings' => 0,
				'parent_repeater' => 'field_items_wine_links',
			],
			[
				'key' => 'field_image',
				'label' => 'Image',
				'name' => 'image',
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
				'parent_repeater' => 'field_items_wine_links',
			],
		],
	],
];
