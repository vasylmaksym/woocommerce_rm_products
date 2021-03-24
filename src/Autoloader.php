<?php

class Autoloader
{
    private $include_path = '';

    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));

        $this->include_path = untrailingslashit(WCDELPR_PLUGIN_DIRNAME) . '/includes/';
    }

    function autoload($class)
    {
        $class = strtolower($class);

        $file = $this->get_file_name_from_class($class);

        $this->load_file($this->include_path . $file);
    }

    function get_file_name_from_class($class)
    {
        return 'class-' . str_replace('_', '-', $class) . '.php';
    }

    function load_file($path)
    {
        if ($path && is_readable($path)) {
            include_once $path;
            return true;
        }
        return false;
    }
}

new Autoloader();
