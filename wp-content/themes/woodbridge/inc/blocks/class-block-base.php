<?php
/**
 * Theme Block Base
 *
 * Provides common functionality and default settings for ACF blocks.
 * Uses THEME_BLOCK_CATEGORY and THEME_TEXT_DOMAIN constants (defined in functions.php).
 */
class Theme_Block_Base {

    /**
     * Default block supports configuration
     *
     * @return array
     */
    public static function get_default_supports() {
        return [
            'align'                => true,
            'mode'                 => 'edit',
            'jsx'                  => true,
            'multiple'             => true,
            'anchor'               => true,
            '__experimentalLayout' => true,
            'align_content'        => 'matrix',
            'ui'                   => true,
            'html'                 => false,
            'customClassName'      => true,
            'alignContent'         => true,
        ];
    }

    /**
     * Get block category slug
     *
     * @return string
     */
    public static function get_category() {
        return defined( 'THEME_BLOCK_CATEGORY' ) ? THEME_BLOCK_CATEGORY : 'theme-blocks';
    }

    /**
     * Get the theme text domain
     *
     * @return string
     */
    public static function get_text_domain() {
        return defined( 'THEME_TEXT_DOMAIN' ) ? THEME_TEXT_DOMAIN : 'theme-starter';
    }

    /**
     * Register a block with ACF from a block.json config array
     *
     * @param array  $config     Parsed block.json data (name, title, description, icon, keywords, post_types)
     * @param string $block_dir  Absolute path to the block directory (used to derive render_template)
     * @return void
     */
    public static function register_block( $config, $block_dir = '' ) {
        if ( ! function_exists( 'acf_register_block_type' ) ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( '[THEME BLOCKS] Cannot register block "' . ( $config['name'] ?? 'unknown' ) . '": ACF not available' );
            }
            return;
        }

        $text_domain = self::get_text_domain();

        // Build registration args from block.json config
        $args = [
            'name'        => $config['name'],
            'title'       => __( $config['title'] ?? '', $text_domain ),
            'description' => __( $config['description'] ?? '', $text_domain ),
            'icon'        => $config['icon'] ?? 'block-default',
            'keywords'    => $config['keywords'] ?? [],
            'category'    => self::get_category(),
            'supports'    => self::get_default_supports(),
        ];

        // Optional: restrict to specific post types
        if ( ! empty( $config['post_types'] ) ) {
            $args['post_types'] = $config['post_types'];
        }

        // Store innerBlocks config so templates can access it via $block['inner_blocks_config']
        if ( ! empty( $config['innerBlocks'] ) && is_array( $config['innerBlocks'] ) ) {
            $args['inner_blocks_config'] = $config['innerBlocks'];
        }

        // Derive render_template from block directory
        if ( $block_dir ) {
            $template_path = $block_dir . '/template.php';
            if ( file_exists( $template_path ) ) {
                $args['render_template'] = $template_path;
            } else {
                if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    error_log( '[THEME BLOCKS] Template not found for block "' . $config['name'] . '": ' . $template_path );
                }
                return;
            }
        }

        // Register the block
        $result = acf_register_block_type( $args );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $block_name = $config['name'] ?? 'unknown';
            if ( $result ) {
                error_log( '[THEME BLOCKS] Registered block: ' . $block_name );
            } else {
                error_log( '[THEME BLOCKS] FAILED to register block: ' . $block_name );
            }
        }
    }

    /**
     * Render an <InnerBlocks /> tag with attributes from the block's innerBlocks config.
     *
     * Usage in template.php:
     *   <?php Theme_Block_Base::render_inner_blocks( $block ); ?>
     *
     * @param array $block The $block array passed to every ACF block template.
     * @return void
     */
    public static function render_inner_blocks( $block ) {
        $config = $block['inner_blocks_config'] ?? [];
        $attrs  = [];

        if ( ! empty( $config['allowedBlocks'] ) ) {
            $attrs[] = 'allowedBlocks=\'' . esc_attr( wp_json_encode( $config['allowedBlocks'] ) ) . '\'';
        }

        if ( ! empty( $config['template'] ) ) {
            $attrs[] = 'template=\'' . esc_attr( wp_json_encode( $config['template'] ) ) . '\'';
        }

        if ( isset( $config['templateLock'] ) ) {
            $lock    = $config['templateLock'];
            $attrs[] = 'templateLock=\'' . esc_attr( is_string( $lock ) ? $lock : ( $lock ? 'all' : 'false' ) ) . '\'';
        }

        echo '<InnerBlocks ' . implode( ' ', $attrs ) . ' />';
    }

    /**
     * Register ACF field group for a block
     *
     * @param string $block_name Block name (e.g., 'hero')
     * @param array  $fields     Field configuration array
     * @return void
     */
    public static function register_fields( $block_name, $fields ) {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
            return;
        }

        acf_add_local_field_group( [
            'key'      => 'group_' . str_replace( '-', '_', $block_name ),
            'title'    => ucwords( str_replace( '-', ' ', $block_name ) ),
            'fields'   => $fields,
            'location' => [
                [
                    [
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/' . $block_name,
                    ],
                ],
            ],
        ] );
    }
}
