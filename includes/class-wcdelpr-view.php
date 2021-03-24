<?php

class WCDelPR_View
{
    public static function include_template($template_name, $params = [])
    {
        $file = WCDELPR_PLUGIN_DIRNAME . "/templates/{$template_name}.php";
        if (file_exists($file)) {
            extract($params);
            include $file;
        }
    }
}
