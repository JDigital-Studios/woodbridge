# ACF Blocks System

Convention-based, auto-discovered ACF Gutenberg blocks.

## Structure

Each block lives in its own directory under `inc/blocks/`:

```
inc/blocks/
├── class-block-base.php      # Base helper class (Theme_Block_Base)
├── class-block-loader.php    # Auto-discovery loader (Theme_Block_Loader)
├── load-blocks.php           # Entry point (hooks into init + acf/init)
├── hero/
│   ├── block.json            # Block metadata (name, title, icon, keywords)
│   ├── fields.php            # Returns ACF field definitions array
│   └── template.php          # Render template
└── ...
```

## Adding a New Block

1. Create a directory under `inc/blocks/` (e.g., `my-new-block/`)
2. Add three files:

### block.json

```json
{
  "title": "My New Block",
  "description": "Description of my block.",
  "icon": "admin-generic",
  "keywords": ["keyword1", "keyword2"]
}
```

The block name is inferred from the directory — no `name` key needed.

Optional: add `"post_types": ["page", "post"]` to restrict which post types can use the block.

Optional: add `"innerBlocks"` to allow nested blocks. See the InnerBlocks section below.

### fields.php

```php
<?php
/**
 * My New Block — ACF field definitions.
 * Return an array of ACF field configs.
 */
return [
    [
        'key'   => 'field_my_new_block_heading',
        'label' => 'Heading',
        'name'  => 'heading',
        'type'  => 'text',
    ],
];
```

### template.php

```php
<?php
$heading = get_field( 'heading' );
?>
<div class="my-new-block">
    <?php if ( $heading ) : ?>
        <h2><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>
</div>
```

That's it — the loader will discover the new block automatically on the next page load.

## Configuration

Two constants in `functions.php` control the block category and text domain:

```php
define( 'THEME_BLOCK_CATEGORY', 'my-theme' );
define( 'THEME_TEXT_DOMAIN', 'my-theme' );
```

## Default Block Supports

All blocks receive these supports via `Theme_Block_Base::get_default_supports()`:

- `align`, `anchor`, `customClassName`, `jsx`, `multiple`
- `mode` → `'edit'`
- `align_content` → `'matrix'`

See `class-block-base.php` for the full list. Override per-block by extending the base class if needed.

## InnerBlocks

Add an `innerBlocks` key to `block.json` to configure nested blocks:

```json
{
    "title": "My Layout Block",
    "innerBlocks": {
        "allowedBlocks": ["core/paragraph", "core/heading"],
        "template": [["core/paragraph", { "placeholder": "Add content..." }]],
        "templateLock": false
    }
}
```

Then render in `template.php` with the helper:

```php
<div class="my-layout">
    <?php Theme_Block_Base::render_inner_blocks( $block ); ?>
</div>
```
