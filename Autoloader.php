<?php

namespace App;

class Autoloader
{

    /**
     * Register autoloader
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Includes the file corresponding to the class
     * @param $class string The name of the class to load
     */
    public static function autoload($className)
    {

        $filename = str_replace(__NAMESPACE__ . '\\', '', $className);
        $filename = str_replace('\\', '/', $filename);
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $filename . '.php';

        if (!file_exists($filename)) {
            return false;
        }
        require_once $filename;
    }
}
