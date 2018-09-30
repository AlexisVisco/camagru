<?php


class UserController extends BaseController
{

    public function register()
    {
        echo self::render("register");
    }

    public function forgotPwd()
    {
        echo self::render("forgot_password");
    }

    public function login()
    {
        echo self::render("login");
    }
}