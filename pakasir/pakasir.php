<?php

/**
 * Plugin Name: Pakasir for WooCommerce
 * Plugin URI:  https://pakasir.gx1.org/
 * Description: Pakasir Payment Gateway for WooComerce.
 * Version:     1.0.0
 * Author:      PT. Geksa Eksplorasi Satu
 * Author URI:  https://gx1.org/
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
      null,
      true
    );

    wp_enqueue_script('pakasir-blocks');
  }
});
