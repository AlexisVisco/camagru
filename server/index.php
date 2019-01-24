<?php

require_once './config/database.php';
require_once './config/Routes.php';
require_once './config/Mails.php';
require_once './config/configuration.php';
require_once './config/setup.php';

require_once './controllers/Autoloader.php';
require_once './models/Autoloader.php';
require_once './util/Autoloader.php';
require_once './forms/Autoloader.php';

require_once './router/Router.php';

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
    ->addRoute("",                           "HomeController@index",                   RouteOrder::$ROUTE)

    // USER ROUTES
    //
    ->addRoute(Routes::$USER_CONFIRM,               "UserController@confirm",                 RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_REGISTER,              "UserController@register",                RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_LOGIN,                 "UserController@login",                   RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_LOGOUT,                "UserController@logout",                  RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_FORGOT_PWD,            "UserController@forgotPwd",               RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_CHANGE_PWD,            "UserController@changePwd",               RouteOrder::$ROUTE)
    ->addRoute(Routes::$USER_SETTINGS,              "UserController@settings",                RouteOrder::$ROUTE)

    // PICTURE ROUTES
    //
    ->addRoute(Routes::$PICTURE_ADD_PHOTO,          "PictureController@addPicture",           RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_ADD_PHOTO_UPLOAD,   "PictureController@addPictureUpload",     RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_GALLERY,            "PictureController@gallery",              RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_LIKE,               "PictureController@like",                 RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_COMMENT,            "PictureController@comment",              RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_DELETE,             "PictureController@delete",               RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_DESC,               "PictureController@picture",              RouteOrder::$ROUTE)
    ->addRoute(Routes::$PICTURE_MY_PICTURES,        "PictureController@myPictures",           RouteOrder::$ROUTE)

    // 404 NOT FOUND
    //
    ->else(function () {
        echo "<div style='margin: auto'><h3>Page introuvable.</h3></div>";
    });

if (isset($_GET["url"])) $router->entry($_GET["url"]);
else $router->entry("");
