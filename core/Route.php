<?php
namespace core;

class Route
{
    private static $routes = [];
    private static $currentRoute = [];
    private static $groupMiddleware = [];
    private static $prefix = '';
    private static $controllerNamespace = "controller\\";
    private static $middlewareNamespace = "middleware\\";

    public static function init()
    {
        include_once __DIR__ . '/http/web.php';
    }

    public static function get_routes()
    {
        return self::$routes;
    }

    public static function add($path, $controllerMethod, $methods = ['GET'], $middleware = [])
    {
        // Apply group middleware and prefix to each route
        $path = self::$prefix . $path;

        // Automatically resolve controller namespace
        $controllerMethod = self::resolveNamespace($controllerMethod, self::$controllerNamespace);

        // Merge group middleware with route-specific middleware
        $middleware = array_merge(self::$groupMiddleware, self::resolveMiddleware($middleware));

        self::$currentRoute = [
            'path' => $path,
            'controllerMethod' => $controllerMethod,
            'methods' => $methods,
            'middleware' => $middleware
        ];

        self::$routes[] = self::$currentRoute;

        return new self;
    }

    public static function get($path, $controllerMethod, $middleware = [])
    {
        return self::add($path, $controllerMethod, ['GET'], $middleware);
    }

    public static function post($path, $controllerMethod, $middleware = [])
    {
        return self::add($path, $controllerMethod, ['POST'], $middleware);
    }

    public static function put($path, $controllerMethod, $middleware = [])
    {
        return self::add($path, $controllerMethod, ['PUT'], $middleware);
    }

    public static function delete($path, $controllerMethod, $middleware = [])
    {
        return self::add($path, $controllerMethod, ['DELETE'], $middleware);
    }

    public static function patch($path, $controllerMethod, $middleware = [])
    {
        return self::add($path, $controllerMethod, ['PATCH'], $middleware);
    }

    public static function options($path, $controllerMethod, $middleware = [])
    {
        return self::add($path, $controllerMethod, ['OPTIONS'], $middleware);
    }

    public static function middleware($middleware)
    {
        if (!isset(self::$currentRoute['middleware'])) {
            self::$currentRoute['middleware'] = [];
        }

        // Add middleware classes to the current route
        if (is_array($middleware)) {
            foreach ($middleware as $middlewareClass) {
                self::$currentRoute['middleware'][] = self::resolveNamespace($middlewareClass, self::$middlewareNamespace);
            }
        } else {
            self::$currentRoute['middleware'][] = self::resolveNamespace($middleware, self::$middlewareNamespace);
        }

        // Update the last route in the routes array
        self::$routes[array_key_last(self::$routes)] = self::$currentRoute;

        return new self;
    }

    public static function group(array $options, callable $callback)
    {
        // Capture prefix and middleware for the group
        $currentPrefix = self::$prefix;
        $currentGroupMiddleware = self::$groupMiddleware;

        if (isset($options['prefix'])) {
            self::$prefix = rtrim($options['prefix'], '/') . '/';
        }

        if (isset($options['middleware'])) {
            $middleware = is_array($options['middleware']) ? $options['middleware'] : [$options['middleware']];
            foreach ($middleware as $middlewareClass) {
                self::$groupMiddleware[] = self::resolveNamespace($middlewareClass, self::$middlewareNamespace);
            }
        }

        // Execute the callback to define group routes
        $callback();

        // Restore the original group settings after the group is processed
        self::$prefix = $currentPrefix;
        self::$groupMiddleware = $currentGroupMiddleware;
    }

    private static function resolveNamespace($className, $defaultNamespace)
    {
        // Only add default namespace if the class name does not already include a namespace
        if (strpos($className, '\\') === false) {
            return $defaultNamespace . $className;
        }
        return $className;
    }

    private static function resolveMiddleware($middleware)
    {
        // Resolve the namespace for an array of middleware classes
        if (is_array($middleware)) {
            return array_map(function ($className) {
                return self::resolveNamespace($className, self::$middlewareNamespace);
            }, $middleware);
        }

        return [self::resolveNamespace($middleware, self::$middlewareNamespace)];
    }
}
