<?php

namespace Camagru\Forms;

class Autoloader{

    /**
     * Register the autoloader
     */
    static function register(){

        require_once 'FormValidation.php';

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Include the corresponding file from the class name
     * @param $class string the name of the class to load
     */
    static function autoload($class){
        if (file_exists('forms/' . $class . '.php')) require_once 'forms/' . $class . '.php';
    }

}