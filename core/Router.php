<?php

namespace core;

use core\exceptions\RouteNotFoundException;
use core\helpers\LocaleHelper;
use Psr\Container\ContainerInterface; // PSR-11 Container Interface for DI

class Router
{
    private $routes = [];
    private $defaultRoute;
    private $app_name;
    private $app_base_url;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_base_url = rtrim(getenv("APP_BASE_URL"), '/');
        $this->container = $container;
    }

    public function setDefaultRoute($controllerMethod)
    {
        $this->defaultRoute = $controllerMethod;
    }

    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    public function routeRequest($path, $method = 'GET')
    {
        try {
            $this->handleRequest($path, $method);
        } catch (RouteNotFoundException $e) {
            $this->handleError(404, $e->getMessage());
        }
    }

    private function handleRequest($requestedUrl, $method = 'GET')
    {
        $requestedUrl = LocaleHelper::cleanLocaleFromRoute($requestedUrl);
        $requestedUrl = str_replace($this->app_base_url, '', $requestedUrl);
        $path = parse_url($requestedUrl, PHP_URL_PATH);

        $queryParams = $this->parseQueryString($requestedUrl);

        try {
            // Check if the route exists for the given HTTP method
            $matchingRoutes = array_filter($this->routes, function ($route) use ($path, $method) {
                return $this->matchRoute($route['path'], $path) && in_array($method, $route['methods']);
            });

            if (!empty($matchingRoutes)) {
                $route = reset($matchingRoutes);

                if ($route) {
                    $this->applyMiddleware($route);

                    // Check if the controllerMethod is a callable
                    if (is_callable($route['controllerMethod'])) {
                        dd($route['controllerMethod']);
                        call_user_func($route['controllerMethod'], ...array_values($queryParams));
                    } else {
                        $this->invokeController($route, $path, $queryParams);
                    }
                }
            } else {
                throw new RouteNotFoundException();
            }
        } catch (RouteNotFoundException $e) {
            $e->render_404();
        }
    }

    private function parseQueryString($url)
    {
        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $queryParams);
        return $queryParams;
    }

    private function applyMiddleware($route)
    {
        if (!isset($route['middleware']) || empty($route['middleware'])) {
            return true; // No middleware, allow request to proceed
        }

        foreach ($route['middleware'] as $middlewareDefinition) {
            // Check if middleware has arguments (e.g., "RoleMiddleware:admin,user")
            if (strpos($middlewareDefinition, ':') !== false) {
                list($middlewareClass, $argsString) = explode(':', $middlewareDefinition, 2);
                $args = explode(',', $argsString);
            } else {
                $middlewareClass = $middlewareDefinition;
                $args = [];
            }

            // Resolve middleware class from container
            if ($this->container->has($middlewareClass)) {
                // If the container knows about the middleware, resolve it
                // Pass dynamic arguments (e.g., params) if needed
                $middleware = $this->container->get($middlewareClass, ['params' => $args]);
            } else {
                // If not in the container, directly create the middleware instance and pass arguments
                $middleware = new $middlewareClass(...$args);
            }

            // Check if middleware passes
            if (!$middleware->handle()) {
                exit(); // Block the request if the middleware check fails
            }
        }
    }

    private function invokeController($route, $path, $queryParams)
    {
        list($controllerName, $methodName) = explode('@', $route['controllerMethod']);
        $controller = $this->resolveController($controllerName);
        $routeParams = $this->extractRouteParameters($route['path'], $path);
        $params = array_merge($routeParams, $queryParams);
        call_user_func_array([$controller, $methodName], $params);
    }

    private function resolveController($controllerName)
    {
        // Use DI Container to resolve the controller
        return $this->container->get($controllerName);
    }

    private function handleError($statusCode, $message)
    {
        http_response_code($statusCode);
        echo $message;
    }

    private function matchRoute($routePath, $requestedPath)
    {
        $routePathParts = explode('/', trim($routePath, '/'));
        $requestedPathParts = explode('/', trim($requestedPath, '/'));

        if (count($routePathParts) !== count($requestedPathParts)) {
            return false;
        }

        foreach ($routePathParts as $index => $part) {
            if (preg_match('/^{\w+}$/', $part)) {
                continue;
            }

            if ($part !== $requestedPathParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private function extractRouteParameters($routePath, $requestedPath)
    {
        $routeParams = [];
        $routePathParts = explode('/', trim($routePath, '/'));
        $requestedPathParts = explode('/', trim($requestedPath, '/'));

        foreach ($routePathParts as $index => $part) {
            if (preg_match('/^{\w+}$/', $part)) {
                $paramName = trim($part, '{}');
                $routeParams[$paramName] = $requestedPathParts[$index];
            }
        }

        return $routeParams;
    }
}
