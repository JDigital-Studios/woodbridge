<?php
/**
 * ACF Field Group Loader
 *
 * Auto-loads ACF field group definitions that are NOT associated with blocks
 * (e.g., page templates, options pages). Block fields are loaded by Theme_Block_Loader.
 */

function theme_load_acf_field_groups() {
    $fields_dir = get_template_directory() . '/inc/acf-fields/';
    $scan_dirs  = [ 'templates' ]; // Add other subdirectories here as needed

    foreach ( $scan_dirs as $dir ) {
        $path = $fields_dir . $dir;
        if ( is_dir( $path ) ) {
            $files = glob( $path . '/*.php' );
            if ( $files ) {
                foreach ( $files as $file ) {
                    require_once $file;
                }
            }
        }
    }
}
add_action( 'acf/init', 'theme_load_acf_field_groups', 4 );
