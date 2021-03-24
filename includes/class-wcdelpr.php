<?php

class WCDelPR
{
    private $action = 'wcdelpr';
    private $delete = 'wcdelpr_delete';
    private $insert = 'wcdelpr_insert';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'delete_products_init']);

        add_action("admin_action_{$this->action}", [$this, 'wcdelpr']);
    }

    function wcdelpr($type)
    {
        $type = $_POST['type'];

        switch ($type) {
            case $this->delete:
                WCDelPr_Query::proc_wc_products_delete_run();
                break;

            case $this->insert:
                WCDelPr_Query::proc_wc_products_insert_run();
                break;

            default:
        }

        wp_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    static function activation()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('Install(Activate) WooCommecre Plugin!', WCDELPR_PLUGIN_TEXTDOMAIN));
        }

        WCDelPr_Query::proc_wc_products_insert();
        WCDelPr_Query::proc_wc_products_delete();
    }

    function delete_products_init()
    {
        add_menu_page(
            __('Woocommerce Products', WCDELPR_PLUGIN_TEXTDOMAIN),
            __('Delete Products', WCDELPR_PLUGIN_TEXTDOMAIN),
            'manage_options',
            'delete-woo-products',
            [$this, 'delete_woo_products_init']
        );
    }

    function delete_woo_products_init()
    {
        $count = WCDelPr_Query::get_wc_product_count();
?>
        <h1> <?= __('Delete WooCoomerce products', WCDELPR_PLUGIN_TEXTDOMAIN) ?></h1>

        <?php WCDelPR_View::include_template(
            'form',
            ['action' => $this->action, 'type' => $this->delete, 'button' => __('Delete', WCDELPR_PLUGIN_TEXTDOMAIN) . " {$count} WooCommerce " . __('products')]
        ); ?>

        <br>

        <?php WCDelPR_View::include_template(
            'form',
            ['action' => $this->action, 'type' => $this->insert, 'button' => __('Insert 500 000 test records')]
        ); ?>

<?php
    }
}
