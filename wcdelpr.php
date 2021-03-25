<?php

/**
 * Plugin Name: WooCommerce Delete Products
 * Plugin URI: https://github.com/vasylmaksym/woocommerce_rm_products.git
 * Description: The plugin has one page with one button. On press this button, the plugin should delete all products from WooCommerce.
 * Version: 1.0
 * Author: Vasyl
 * Author URI: https://www.linkedin.com/in/vasyl-maksym-3655681a0/
 */


defined('ABSPATH') || exit;

if (!defined('WCDELPR_PLUGIN_DIRNAME')) {
    define('WCDELPR_PLUGIN_DIRNAME', dirname(__FILE__));
}

if (!defined('WCDELPR_PLUGIN_TEXTDOMAIN')) {
    define('WCDELPR_PLUGIN_TEXTDOMAIN', 'wc_rm_products');
}

if (!defined('WC_PRODUCT_POST_TYPE')) {
    define('WC_PRODUCT_POST_TYPE', 'product');
}

include_once WCDELPR_PLUGIN_DIRNAME . '/src/Autoloader.php';

$GLOBALS['delete_woocommerce_products'] = new WCDelPR();

register_activation_hook(__FILE__, array('WCDelPr', 'activation'));
register_deactivation_hook(__FILE__, array('WCDelPr', 'deactivation'));
