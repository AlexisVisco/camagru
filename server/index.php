<?php

require_once './config/Database.php';
require_once './config/Routes.php';
require_once './controllers/Autoloader.php';
require_once './models/Autoloader.php';
require_once './router/Router.php';

define("ROOT", __DIR__);
session_start();

date_default_timezone_set('Europe/Paris');

Camagru\Controllers\Autoloader::register();
Camagru\Models\Autoloader::register();

$router = Router::getInstance();

$router

    //----------------------------------------->
    //
    // HOME ROUTE
    //
    //----------------------------------------->
    ->addRoute("",                          "HomeController@index",         RouteOrder::$ROUTE)

    //----------------------------------------->
    //
    // USER ROUTES
    //
    //----------------------------------------->
    ->addRoute(Routes::$USER_REGISTER,      "UserController@register",      RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_LOGIN,         "UserController@login",         RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_FORGOT_PWD,    "UserController@forgotPwd",     RouteOrder::$ROUTE)

    //----------------------------------------->
    //
    // 404 NOT FOUND
    //
    //----------------------------------------->
    ->else(function () {
        echo "404.NotFound";
    });


if (isset($_GET["url"])) $router->entry($_GET["url"]);
else $router->entry("");
