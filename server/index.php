<?php

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
    ->addRoute("hey/george/(\d+)/(\d+)/", "UserController@georgeBefore", RouteOrder::$BEFORE)
    ->addRoute("hey/george/(\d+)/(\d+)/", "UserController@george", RouteOrder::$ROUTE)
    ->addRoute("hey/george/", "UserController@home", RouteOrder::$ROUTE)
    ->else(function () {
        header('Content-Type: application/json');
        echo json_encode(Errors::NotFound());
    });

if (isset($_GET["url"])) {
    $router->entry($_GET["url"]);
} else {
    echo json_encode(new Status());
}