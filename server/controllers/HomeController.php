<?php


class HomeController extends BaseController
{
    function index() {
        echo self::render("home");
    }
}