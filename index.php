<?php

use core\container\Container;
use Dotenv\Dotenv;
use core\Route;
use core\Router;

require_once "vendor/autoload.php";
require_once "autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();

$container->autoRegister(__DIR__ . '/controller', 'controller\\');
$container->autoRegister(__DIR__ . '/middleware', 'middleware\\');

Route::init();

$router = new Router($container);

$router->setDefaultRoute("controller\AuthController@index");

$routes = Route::get_routes();

$router->setRoutes($routes);

$router->routeRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
