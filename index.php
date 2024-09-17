<?php

use core\container\Container;
use core\DatabaseConnection;
use core\log\Logger;
use core\Registry;
use Dotenv\Dotenv;
use core\Route;
use core\Router;

require_once "vendor/autoload.php";
require_once "autoload.php";
require_once "core/Functions.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();
$container->autoRegister(__DIR__ . '/controller', 'controller\\');
$container->autoRegister(__DIR__ . '/middleware', 'middleware\\');

Registry::set("locales", ['en', 'fr', 'de']);

$connection = DatabaseConnection::init();
$database = $connection->get_connection();
Registry::set("database", $database);

$Logger = Logger::get_instance();
Registry::set("logger", $Logger);


Route::init();
$routes = Route::get_routes();

$router = new Router($container);
$router->setDefaultRoute("controller\AuthController@index");
$router->setRoutes($routes);
$router->routeRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
