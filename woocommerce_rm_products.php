<?php

/**
 * Plugin Name: woocommerce_rm_products
 * Plugin URI: https://github.com/vasylmaksym/woocommerce_rm_products.git
 * Description: The plugin has one page with one button. On press this button, the plugin should delete all products from WooCommerce.
 * Version: 1.0
 * Author: Vasyl
 * Author URI: https://www.linkedin.com/in/vasyl-maksym-3655681a0/
 */


defined('ABSPATH') || exit;

if (!defined('WC_RM_PLUGIN_FILE')) {
    define('WC_RM_PLUGIN_FILE', __FILE__);
}

if (!defined('WC_RM_PLUGIN_TEXTDOMAIN')) {
    define('WC_RM_PLUGIN_TEXTDOMAIN', 'wc_rm_products');
}

if (!class_exists('DeleteProducts', false)) {
    include_once dirname(WC_RM_PLUGIN_FILE) . '/includes/class-delete-products.php';
}

$GLOBALS['delete_woocommerce_products'] = new DeleteProducts();

register_activation_hook(__FILE__, array('DeleteProducts', 'activation_check'));
