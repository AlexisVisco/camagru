<?php

require_once './config/Database.php';
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
    ->addRoute("", "Home@index", RouteOrder::$ROUTE)
    ->else(function () {
        echo "404.NotFound";
    });

if (isset($_GET["url"])) $router->entry($_GET["url"]);
else $router->entry("");


$user = new User();
$user = $user->load("fijewnfiwefw");
/* @var User $user  */
$user->init("kwixxy", "lolcc@outlook.fr", "ewdeewdewdew");
$user->save();
