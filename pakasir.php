<?php

/**
 * Plugin Name: Pakasir for WooCommerce
 * Plugin URI:  https://pakasir.com/
 * Description: Pakasir Payment Gateway (QRIS, Virtual Account, etc) for WooComerce.
 * Version:     1.2.0
 * Author:      PT. Geksa Eksplorasi Satu
 * Author URI:  https://gx1.org/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: pakasir-for-woocommerce
 */

if (!defined('ABSPATH')) {
  exit;
}

// Load gateway after WooCommerce ready
function pakasir_init_gateway()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-wc-gateway-pakasir.php';
}
add_action('plugins_loaded', 'pakasir_init_gateway');

// Add Manage link, next to deactivate plugin link
function pakasir_add_plugin_action_links($links)
{
  $settings_link = '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=pakasir') . '">Manage</a>';
  array_unshift($links, $settings_link);
  return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'pakasir_add_plugin_action_links');

// Add pakasir blocks integration
add_action('enqueue_block_assets', function () {
  if (is_checkout()) {
    wp_register_script(
      'pakasir-blocks',
      plugin_dir_url(__FILE__) . 'assets/pakasir-blocks-integration.js',
      array('react', 'wp-element', 'wp-hooks', 'wc-blocks-registry', 'wc-blocks-checkout'),
      true,
      true
    );

    $pakasir_settings = get_option('woocommerce_pakasir_settings');
    $title = $pakasir_settings['title'];
    $description = $pakasir_settings['description'];
    wp_localize_script(
      'pakasir-blocks',
      'pakasir_checkout_data',
      [
        'title' => $title,
        'description' => $description,
      ]
    );

    wp_enqueue_script('pakasir-blocks');
  }
});

register_activation_hook( __FILE__, 'myplugin_check_woocommerce' );

function myplugin_check_woocommerce() {
    // Cek apakah WooCommerce aktif
    if ( ! class_exists( 'WooCommerce' ) ) {
        // Matikan plugin kita
        deactivate_plugins( plugin_basename( __FILE__ ) );

        // Tampilkan pesan error
        wp_die(
            'Plugin ini memerlukan WooCommerce untuk berjalan. 
            Silakan instal dan aktifkan WooCommerce terlebih dahulu.',
            'Plugin Dibatalkan',
            array( 'back_link' => true )
        );
    }
}