<?php

use Dotenv\Dotenv;
use core\Route;

require_once "vendor/autoload.php";
require_once "autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

Route::init();

$router = new core\Router();

$router->setDefaultRoute("controller\AuthController@index");

$routes = Route::get_routes();

$router->setRoutes($routes);

$router->routeRequest($_SERVER['REQUEST_URI'], "middleware\AuthMiddleware");
