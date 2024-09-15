<?php

namespace core;

use core\exceptions\RouteNotFoundException;
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
                    $this->invokeController($route, $path, $queryParams);
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

        if (!isset($route['middleware'])) {
            return;
        }
        foreach ($route['middleware'] as $middlewareClass) {
            $middleware = $this->container->get($middlewareClass);
            if (!$middleware->handle()) {
                
                exit();
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
