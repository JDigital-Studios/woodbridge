<?php
/**
 * Products Slider Block Fields
 *
 * Return an array of ACF field definitions.
 * The block loader will automatically register these fields.
 */


return [
	[
		'key' => 'field_headline',
		'label' => 'Headline',
		'name' => 'headline',
		'aria-label' => '',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'default_value' => '',
		'maxlength' => '',
		'allow_in_bindings' => 0,
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
	],
	[
		'key' => 'field_products_slider',
		'label' => 'Items',
		'name' => 'products_slider',
		'aria-label' => '',
		'type' => 'relationship',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'post_type' => [
			0 => 'wine',
		],
		'post_status' => '',
		'taxonomy' => '',
		'filters' => [
			0 => 'search',
		],
		'return_format' => 'id',
		'min' => '',
		'max' => '',
		'allow_in_bindings' => 0,
		'elements' => '',
		'bidirectional' => 0,
		'bidirectional_target' => [],
	],
];
