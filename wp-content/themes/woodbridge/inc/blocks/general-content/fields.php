<?php
/**
 * General Content Block Fields
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
		'key' => 'field_content',
		'label' => 'Content',
		'name' => 'content',
		'aria-label' => '',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => [
			'width' => '',
			'class' => '',
			'id' => '',
		],
		'default_value' => '',
		'allow_in_bindings' => 0,
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 0,
		'delay' => 0,
	],
];
