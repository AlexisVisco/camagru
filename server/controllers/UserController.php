<?php


class UserController extends BaseController
{
    public function home()
    {
        echo "Im at home";
    }

    public function george($lel, $ok)
    {
        echo "george after";

    }

    public function georgeBefore($lel, $ok)
    {
        echo self::render("home", [
                "lel" => $lel,
                "ok" => $ok]
        );
        return false;
    }
}