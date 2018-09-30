<?php


class Home extends BaseController
{
    function index() {
        echo self::render("home");
    }
}