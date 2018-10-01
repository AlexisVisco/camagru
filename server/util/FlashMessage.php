<?php


class FlashMessage
{
    public $message;
    public $type;

    /**
     * Flash constructor.
     *
     * @param $message
     * @param $type
     */
    public function __construct($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function register() {
        $_SESSION["flash_message"] = json_encode($this);
    }

    public static function consume() : FlashMessage {
        $flash = json_decode($_SESSION["flash_message"]) ;
        if ($flash == NULL) return NULL;


        $flashObject = new FlashMessage("", NULL);
        foreach ($flash as $key => $value) $flashObject->{$key} = $value;
        $_SESSION["flash_message"] = NULL;
        return $flashObject;

    }

    public static function hasFlash() {
        return $_SESSION["flash_message"] != NULL;
    }

    public static function html() {
        include ROOT . "/views/util/notifications.php";
    }
}

class FlashType {
    public static $SUCCESS = "success";
    public static $ERROR = "error";
    public static $WARNING = "warning";
}