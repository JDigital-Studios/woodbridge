<?php
/**
 * Load ACF Blocks System
 *
 * Initializes the convention-based block loader.
 * Blocks are auto-discovered from inc/blocks/{name}/block.json.
 */

// Load base classes early (on init)
add_action( 'init', function () {
    require_once get_template_directory() . '/inc/blocks/class-block-base.php';
    require_once get_template_directory() . '/inc/blocks/class-block-loader.php';
}, 1 );

// Discover and register all blocks on acf/init
add_action( 'acf/init', function () {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    $loader = new Theme_Block_Loader();
    $loader->load_blocks();
}, 5 );
