<?php

class BaseController
{

    public function redirect($url)
    {
        header("Location:$url");
        exit;
    }

    public static function render($file, $variables = []) {
        extract($variables);
        ob_start();
        include ROOT . "/views/$file.php";
        $body = ob_get_clean();
        ob_start();
        include ROOT . "/views/main.php";
        return ob_get_clean();
    }
}