<?php
/**
 * Heritage Block Fields
 *
 * Return an array of ACF field definitions.
 * The block loader will automatically register these fields.
 */


return [
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
	],
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
		'key' => 'field_description',
		'label' => 'Description',
		'name' => 'description',
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
	[
		'key' => 'field_button',
		'label' => 'Button',
		'name' => 'button',
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
	],
];
