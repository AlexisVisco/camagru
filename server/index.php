<?php

require_once './config/Database.php';
require_once './config/Routes.php';

require_once './controllers/Autoloader.php';
require_once './models/Autoloader.php';
require_once './util/Autoloader.php';
require_once './forms/Autoloader.php';

require_once './router/Router.php';

define("ROOT", __DIR__);
define("SALT", "f8e4w89fwefew");
session_start();

date_default_timezone_set('Europe/Paris');

Camagru\Controllers\Autoloader::register();
Camagru\Models\Autoloader::register();
Camagru\Util\Autoloader::register();
Camagru\Forms\Autoloader::register();

$router = Router::getInstance();

$router

    // HOME ROUTE
    //
    ->addRoute("",                          "HomeController@index",         RouteOrder::$ROUTE)

    // USER ROUTES
    //
    ->addRoute(Routes::$USER_REGISTER,      "UserController@register",      RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_LOGIN,         "UserController@login",         RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_LOGOUT,        "UserController@logout",        RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_FORGOT_PWD,    "UserController@forgotPwd",     RouteOrder::$ROUTE)

    // 404 NOT FOUND
    //
    ->else(function () {
        echo "404.NotFound";
    });

$to = "alexis.viscogliosi@outlook.fr";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: mail@camagru.net";

var_dump(mail($to,$subject,$txt,$headers));

if (isset($_GET["url"])) $router->entry($_GET["url"]);
else $router->entry("");
