<?php

namespace Camagru\Util;

class Autoloader{

    /**
     * Register the autoloader
     */
    static function register(){

        require_once 'FlashMessage.php';
        require_once 'Messages.php';
        require_once 'Mailer.php';

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Include the corresponding file from the class name
     * @param $class string the name of the class to load
     */
    static function autoload($class){
        if (file_exists('util/' . $class . '.php')) require_once 'util/' . $class . '.php';
    }

}