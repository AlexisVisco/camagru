<?php

namespace Camagru\Models;

class Autoloader {

    /**
     * Register the autoloader
     */
    static function register(){

        require_once 'util/Storage.php';

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Include the corresponding file from the class name
     * @param $class string the name of the class to load
     */
    static function autoload($class){
        if (file_exists('models/' . $class . '.php')) require_once 'models/' . $class . '.php';
    }

}