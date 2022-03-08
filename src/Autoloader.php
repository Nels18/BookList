<?php

namespace App;

class Autoloader{

    /**
     * Register autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Includes the file corresponding to the class
     * @param $class string The name of the class to load
     */
    static function autoload($className){
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filename = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
        $filename = str_replace('App/', '', $filename);
        
        if (is_readable($filename)) {
            require_once($filename);
        }
    }
}