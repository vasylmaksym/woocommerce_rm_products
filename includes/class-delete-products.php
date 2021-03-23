<?php

class DeleteProducts
{
    private $delete_action_name = 'delete_wc_products';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'delete_products_init']);

        add_action("admin_action_{$this->delete_action_name}", [$this, 'delete']);
    }

    static function activation_check()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('Install(Activate) WooCommecre Plugin!', WC_RM_PLUGIN_TEXTDOMAIN));
        }
    }

    function delete_products_init()
    {
        add_menu_page('Woocommerce Products', 'Delete Products', 'manage_options', 'delete-woo-products', [$this, 'delete_woo_products_init']);
    }

    function delete_woo_products_init()
    {
        global $wpdb;
        $count = $wpdb->get_var("select count(*) from {$wpdb->posts} where post_type = 'product'");
?>
        <h1> <?= __('Delete WooCoomerce products', WC_RM_PLUGIN_TEXTDOMAIN) ?></h1>

        <form method="POST" action="<?php echo admin_url('admin.php'); ?>">
            <input type="hidden" name="action" value="<?= $this->delete_action_name; ?>" />
            <input type="submit" value="<?= __('Delete', WC_RM_PLUGIN_TEXTDOMAIN) . " {$count} " . __('WC products', WC_RM_PLUGIN_TEXTDOMAIN);  ?>" />
        </form>
<?php
    }

    function delete()
    {
        global $wpdb;

        $query = "delete
                    p, pm, tr
                from 
                    {$wpdb->posts} p
                left join 
                    {$wpdb->postmeta} pm on pm.post_id = p.ID
                left join 
                    {$wpdb->term_relationships} tr on tr.object_id = p.ID
                where 
                    p.post_type = 'product'";

        $wpdb->query($query);

        wp_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }
}
