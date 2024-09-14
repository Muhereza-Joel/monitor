<?php

namespace core;

class Route
{
    private static $routes = [];

    public static function init()
    {
        include_once __DIR__ . '/http/web.php';
    }

    public static function get_routes()
    {
        return self::$routes;
    }

    public static function add($path, $controllerMethod, $methods = ['GET'])
    {
        self::$routes[] = [
            'path' => $path,
            'controllerMethod' => $controllerMethod,
            'methods' => $methods,
        ];
    }

    public static function get($path, $controllerMethod)
    {
        self::add($path, $controllerMethod, ['GET']);
    }

    public static function post($path, $controllerMethod)
    {
        self::add($path, $controllerMethod, ['POST']);
    }

    public static function put($path, $controllerMethod)
    {
        self::add($path, $controllerMethod, ['PUT']);
    }

    public static function delete($path, $controllerMethod)
    {
        self::add($path, $controllerMethod, ['DELETE']);
    }

    public static function patch($path, $controllerMethod)
    {
        self::add($path, $controllerMethod, ['PATCH']);
    }

    public static function options($path, $controllerMethod)
    {
        self::add($path, $controllerMethod, ['OPTIONS']);
    }
}