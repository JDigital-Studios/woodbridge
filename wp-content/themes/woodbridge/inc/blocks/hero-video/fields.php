<?php
/**
 * Hero Block Fields
 *
 * Return an array of ACF field definitions.
 * The block loader will automatically register these fields.
 */


return [
	[
		'key' => 'field_vimeo_url',
		'label' => 'Vimeo Url',
		'name' => 'vimeo_url',
		'aria-label' => '',
		'type' => 'url',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' =>[
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'default_value' => '',
		'allow_in_bindings' => 0,
		'placeholder' => '',
	]
];
