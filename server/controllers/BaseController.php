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

    /**
     * @param array $fields list of fields name to ensure are set and not blank
     * @return array of fields that are missing or blank
     */
    public function ensure($fields) : array {
        $list = [];
        foreach ($fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $list[$field] = true;
            }
        }
        return $list;
    }
}