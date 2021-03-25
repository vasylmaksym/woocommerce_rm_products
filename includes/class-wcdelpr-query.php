<?php

class WCDelPr_Query
{
    const PROC_PRODUCTS_INSERT = 'wcdelpr_products_insert';
    const PROC_PRODUCTS_DELETE = 'wcdelpr_products_delete';


    public static function proc_wc_products_insert_run()
    {
        return self::proc_run(self::PROC_PRODUCTS_INSERT);
    }

    public static function proc_wc_products_delete_run()
    {
        return self::proc_run(self::PROC_PRODUCTS_DELETE);
    }

    public static function create_procedures()
    {
        self::proc_wc_products_delete();
        self::proc_wc_products_insert();
    }

    public static function drop_procedures()
    {
        global $wpdb;
        $proc_delete = self::PROC_PRODUCTS_DELETE;
        $proc_insert = self::PROC_PRODUCTS_INSERT;
        $wpdb->query("DROP PROCEDURE IF EXISTS {$proc_delete}");
        $wpdb->query("DROP PROCEDURE IF EXISTS {$proc_insert}");
    }

    public static function get_wc_product_count()
    {
        global $wpdb;
        $wc_post_type = WC_PRODUCT_POST_TYPE;
        return $wpdb->get_var("select count(*) from {$wpdb->posts} where post_type = '{$wc_post_type}'");
    }

    static function proc_wc_products_insert()
    {
        global $wpdb;
        $proc_name = self::PROC_PRODUCTS_INSERT;
        $query = "CREATE PROCEDURE IF NOT EXISTS {$proc_name}()   
                    BEGIN
                        DECLARE i INT DEFAULT 1; 
                        WHILE (i <= 100000) DO
                            INSERT INTO 
                                {$wpdb->posts} (post_name, post_content, post_excerpt, post_title, post_type, to_ping, pinged, post_content_filtered) 
                            VALUES ('test','test', 'test', 'test', 'product', false, false, false);
                        SET i = i+1;
                        END WHILE;
                    END;";

        $wpdb->query($query);
    }

    static function proc_wc_products_delete()
    {
        global $wpdb;
        $now = date('Y-m-d H:i:s');
        $proc_name = self::PROC_PRODUCTS_DELETE;
        $wc_product_post_type = WC_PRODUCT_POST_TYPE;

        $query = "CREATE PROCEDURE IF NOT EXISTS {$proc_name}()
                    BEGIN
                    DECLARE counter INT DEFAULT 1;
                        REPEAT
                            DELETE 
                                p, pm, tr 
                            FROM 
                                {$wpdb->posts} p 
                            LEFT JOIN 
                                {$wpdb->postmeta} pm ON pm.post_id = p.ID 
                            LEFT JOIN 
                                {$wpdb->term_relationships} tr ON tr.object_id = p.ID 
                            WHERE 
                                p.post_type = '{$wc_product_post_type}'
                            AND 
                                p.post_date < '{$now}'; 
                            commit;
                            SET counter = counter + 1;
                            SELECT SLEEP(2);
                            UNTIL counter >= 200
                        END REPEAT;
                    END;";
        $wpdb->query($query);
    }

    static function proc_run($name)
    {
        global $wpdb;
        $wpdb->query("CALL {$name}()");
    }
}
