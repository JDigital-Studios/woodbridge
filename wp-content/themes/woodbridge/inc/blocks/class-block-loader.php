<?php
/**
 * Theme Block Loader
 *
 * Auto-discovers blocks from the blocks directory using convention:
 *   inc/blocks/{block-name}/block.json   — block config (name, title, icon, etc.)
 *   inc/blocks/{block-name}/fields.php   — returns ACF field definitions array
 *   inc/blocks/{block-name}/template.php — render template
 */
class Theme_Block_Loader {

    /**
     * @var string Absolute path to the blocks directory
     */
    private $blocks_dir;

    public function __construct() {
        $this->blocks_dir = get_template_directory() . '/inc/blocks';
    }

    /**
     * Discover and register all blocks
     */
    public function load_blocks() {
        if ( ! is_dir( $this->blocks_dir ) ) {
            return;
        }

        $block_dirs = glob( $this->blocks_dir . '/*', GLOB_ONLYDIR );

        if ( empty( $block_dirs ) ) {
            return;
        }

        foreach ( $block_dirs as $block_dir ) {
            $block_name = basename( $block_dir );

            // Skip hidden directories
            if ( strpos( $block_name, '.' ) === 0 ) {
                continue;
            }

            $this->load_block( $block_name, $block_dir );
        }
    }

    /**
     * Load and register a single block from its directory
     *
     * @param string $block_name Block slug (directory name)
     * @param string $block_dir  Absolute path to the block directory
     */
    private function load_block( $block_name, $block_dir ) {
        // 1. Read block.json config
        $json_path = $block_dir . '/block.json';
        if ( ! file_exists( $json_path ) ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( '[THEME BLOCKS] No block.json found for: ' . $block_name );
            }
            return;
        }

        $config = json_decode( file_get_contents( $json_path ), true );
        if ( ! is_array( $config ) ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( '[THEME BLOCKS] Invalid block.json for: ' . $block_name );
            }
            return;
        }

        // Name is always inferred from the directory — block.json never needs a "name" key
        $config['name'] = $block_name;

        // 2. Register the block
        Theme_Block_Base::register_block( $config, $block_dir );

        // 3. Load fields if fields.php exists and returns an array
        $fields_path = $block_dir . '/fields.php';
        if ( file_exists( $fields_path ) ) {
            $fields = include $fields_path;
            if ( is_array( $fields ) && ! empty( $fields ) ) {
                Theme_Block_Base::register_fields( $block_name, $fields );
            }
        }
    }

    /**
     * Get names of all discovered blocks
     *
     * @return array
     */
    public function get_block_names() {
        if ( ! is_dir( $this->blocks_dir ) ) {
            return [];
        }

        $names = [];
        foreach ( glob( $this->blocks_dir . '/*/block.json' ) as $json_path ) {
            $names[] = basename( dirname( $json_path ) );
        }
        return $names;
    }
}
