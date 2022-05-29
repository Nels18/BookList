<?php

namespace App\Core;

class Autoloader
{

    /**
     * Register autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Includes the file corresponding to the class
     * @param $class string The name of the class to load
     */
    public static function autoload($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

        spl_autoload_register(function ($className) {
            $filename = 'src' . DIRECTORY_SEPARATOR . $className . '.php';
            $filename = str_replace('App\\', '', $filename);
            $filename = str_replace('\\', '/', $filename);

            if (!file_exists($filename)) {
                return false;
            }
            include $filename;
        });
    }
}
