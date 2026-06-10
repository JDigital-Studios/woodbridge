<?php

/**
 * Plugin Name: Mio MikMak
 * Description: Custom MikMak integration to display full store locator as page template.
 * Version: 1.0
 * Author: Mio
 * Author URI: https://hellomio.com
 */


// container renderer script
function mio_mikmak_render()
{
  $product_ids = get_field('mikmak_product_ids', 'options');
  $widget_id = get_field('mikmak_widget_id', 'option');
  $css = get_field('mikmak_custom_css', 'options');
?>
  <style>
    #mio-mikmak-wrap iframe {
      width: 100%;
      /* height: 90vh; */
    }

    <?php echo $css ?>
  </style>
  <div id="mio-mikmak-wrap" data-mm-wtbid="<?php echo $widget_id ?>" data-mm-ids="<?php echo $product_ids ?>"> </div>
<?php
}

// add shortcode for render
function mio_mikmak_shortcode()
{
  ob_start();
  mio_mikmak_render();
  return ob_get_clean();
}
add_shortcode('mio-mikmak', 'mio_mikmak_shortcode');


// header script
function mio_mikmak_header_script()
{
  $script_id = get_field('mikmak_script_id', 'option');
?>

  <script>
    /* Start of Swaven tag */
    (function(e, d) {
      try {
        var a = window.swnDataLayer = window.swnDataLayer || {};
        a.appId = e || a.appId, a.eventBuffer = a.eventBuffer || [], a.loadBuffer = a.loadBuffer || [], a.push = a.push || function(e) {
          a.eventBuffer.push(e)
        }, a.load = a.load || function(e) {
          a.loadBuffer.push(e)
        }, a.dnt = a.dnt != null ? a.dnt : d;
        var t = document.getElementsByTagName("script")[0],
          n = document.createElement("script");
        n.async = !0, n.src = "//wtb-tag.mikmak.ai/scripts/" + a.appId + "/tag.min.js", t.parentNode.insertBefore(n, t)
      } catch (e) {
        console.log(e)
      }
    }("<?php echo $script_id ?>", false));
    /* End of Swaven tag */
  </script>
<?php
}
add_action('wp_head', 'mio_mikmak_header_script');


// register template with WordPress
add_filter('template_include', 'mio_plugin_template_include');
function mio_plugin_template_include($template)
{
  if (is_page_template('template-mikmak.php')) {
    $theme_template = locate_template('mikmak.php');
    if (!empty($theme_template)) {
      return $theme_template;  // Use the theme's version of the template if it exists
    }

    $new_template = plugin_dir_path(__FILE__) . 'template-mikmak.php';
    if (file_exists($new_template)) {
      return $new_template;
    }
  }
  return $template;
}

add_filter('theme_page_templates', 'mio_add_custom_template');
function mio_add_custom_template($templates)
{
  $templates['template-mikmak.php'] = 'MikMak Store Locator';
  return $templates;
}


// ACF stuff

// setup options page
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title' => 'MikMak Settings',
    'menu_title' => 'MikMak Settings',
    'menu_slug' => 'mikmak-settings',
    'capability' => 'edit_posts',
    'redirect' => false
  ));
}

// register fields
add_action('acf/include_fields', function () {
  if (!function_exists('acf_add_local_field_group')) {
    return;
  }

  acf_add_local_field_group(array(
    'key' => 'group_6679db556680b',
    'title' => 'MikMak',
    'fields' => array(
      array(
        'key' => 'field_6679dd12c0b2e',
        'label' => 'Script ID',
        'name' => 'mikmak_script_id',
        'aria-label' => '',
        'type' => 'text',
        'instructions' => 'This is the brand-specific ID toward the end of the big embed script code (e.g. 666b8c049b55320f107c5751)',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '50',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'maxlength' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
      ),
      array(
        'key' => 'field_6679dd75c0b30',
        'label' => 'Widget ID (WTBID)',
        'name' => 'mikmak_widget_id',
        'aria-label' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '50',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'maxlength' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
      ),
      array(
        'key' => 'field_6679db55987c0',
        'label' => 'Product UPCs',
        'name' => 'mikmak_product_ids',
        'aria-label' => '',
        'type' => 'textarea',
        'instructions' => 'Enter comma-separated UPCs to control the products that are displayed in the locator.
<br>
e.g. UPC1234,UPC5678,UPC1111',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'maxlength' => '',
        'rows' => '',
        'placeholder' => '',
        'new_lines' => '',
      ),
      array(
        'key' => 'field_6679e53b7fcf4',
        'label' => 'Custom CSS for Store Locator Page',
        'name' => 'mikmak_custom_css',
        'aria-label' => '',
        'type' => 'textarea',
        'instructions' => 'This will be rendered inside a script tag on the MikMak template',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'maxlength' => '',
        'rows' => '',
        'placeholder' => '',
        'new_lines' => '',
      ),
      array(
        'key' => 'field_6679eaaa7db64',
        'label' => 'Developer Customization',
        'name' => '',
        'aria-label' => '',
        'type' => 'message',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => 'You can override the template being used for the store locator page by creating a file named <strong>mikmak.php</strong> in your theme. Render the store locator with the <strong>mio_mikmak_render()</strong> function.',
        'new_lines' => 'wpautop',
        'esc_html' => 0,
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'mikmak-settings',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
      0 => 'the_content',
      1 => 'excerpt',
      2 => 'discussion',
      3 => 'comments',
      4 => 'revisions',
      5 => 'author',
      6 => 'format',
      7 => 'categories',
      8 => 'tags',
      9 => 'send-trackbacks',
    ),
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
});
