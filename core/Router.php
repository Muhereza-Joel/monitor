<?php

namespace core;

class Router
{
    private $routes = [];
    private $defaultRoute;
    private $app_name;
    private $app_base_url;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_base_url = rtrim(getenv("APP_BASE_URL"), '/');
    }

    public function setDefaultRoute($controllerMethod)
    {
        $this->defaultRoute = $controllerMethod;
    }

    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    public function routeRequest($path, $middlewareClass, $method = 'POST')
    {
        $this->handleRequest($path, $middlewareClass, $method);
    }

    private function handleRequest($requestedUrl, $middlewareClass = null, $method = 'GET')
    {
        // Remove the base URL from the requested URL
        $requestedUrl = str_replace($this->app_base_url, '', $requestedUrl);

        // Check if the user is logged in when accessing the base URL
        if ($requestedUrl === "/" && Session::isLoggedIn()) {
            if (Session::get('role') == 'Administrator' || Session::get('role') == 'Viewer' || Session::get('role') == 'User') {
                header("Location: {$this->app_base_url}/dashboard/");
                return;
            }
        }

        // Remove query string parameters from the URL
        $urlParts = explode('?', $requestedUrl);
        $path = $urlParts[0];

        // Check if the route exists for the given HTTP method
        $matchingRoutes = array_filter($this->routes, function ($route) use ($path, $method) {
            return $route['path'] === $path && in_array($method, $route['methods']);
        });

        if (!empty($matchingRoutes)) {
            $route = reset($matchingRoutes);
            // Split the controller and method
            list($controllerName, $methodName) = explode('@', $route['controllerMethod']);

            // Apply middleware if provided
            if ($middlewareClass !== null) {
                $this->applyMiddlewareLogic($middlewareClass, $path, $controllerName, $methodName);
            } else {
                // No middleware, proceed with regular route logic
                $this->handleRegularRouteLogic($path, $controllerName, $methodName);
            }
        } else {
            // Handle 404 Not Found error
            header("HTTP/1.0 404 Not Found");
            header("Location: {$this->app_base_url}/page-not-found/");
            exit();
        }
    }

    private function handleRegularRouteLogic($path, $controllerName = null, $methodName = null)
    {
        // Find the route that matches the specified path
        $matchingRoute = null;
        foreach ($this->routes as $route) {
            if ($route['path'] === $path) {
                $matchingRoute = $route;
                break;
            }
        }

        // Check if a matching route was found
        if ($matchingRoute !== null) {
            // Extract individual details
            $controllerMethod = $matchingRoute['controllerMethod'];
            $methods = $matchingRoute['methods'];

            // Split the controller and method
            list($controllerName, $methodName) = explode('@', $controllerMethod);

            if (!empty($controllerName) && class_exists($controllerName)) {
                $controller = new $controllerName();

                // Extract route parameters from the URL
                $routeParams = $this->extractRouteParameters($path, $_SERVER['REQUEST_URI']);

                // Call the controller method and pass route parameters
                call_user_func_array([$controller, $methodName], $routeParams);
            }
        } else {
            // If the route is not found, return a 404 response
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }

    private function applyMiddlewareLogic($middlewareClass, $path, $controllerName, $methodName)
    {
        // Create an instance of the middleware
        $middleware = new $middlewareClass();

        // Check if the middleware allows access
        if ($middleware->handle()) {
            // Continue with regular route logic
            $this->handleRegularRouteLogic($path, $controllerName, $methodName);
        } else {
            // Handle unauthorized access (e.g., redirect to login page)
            header("Location: {$this->app_base_url}/auth/login/");
            exit();
        }
    }


    private function extractRouteParameters($routePath, $requestedUrl)
    {
        $routeParams = [];
        // Remove query string from requested URL to simplify matching
        $requestedPath = explode('?', $requestedUrl)[0];
        // Normalize leading and trailing slashes
        $normalizedRoutePath = trim($routePath, '/');
        $normalizedRequestedPath = trim($requestedPath, '/');
        // Split paths into segments
        $routeSegments = explode('/', $normalizedRoutePath);
        $requestedSegments = explode('/', $normalizedRequestedPath);
        // Iterate over route segments to find placeholders and match them with requested URL segments
        foreach ($routeSegments as $index => $segment) {
            if (strpos($segment, '{') === 0 && strpos($segment, '}') === (strlen($segment) - 1)) {
                // This segment is a placeholder, extract the parameter name and value
                $paramName = trim($segment, '{}');
                // Check if the requested URL has enough segments to match this placeholder
                if (isset($requestedSegments[$index])) {
                    $routeParams[$paramName] = $requestedSegments[$index];
                }
            }
        }
        // Parse and merge query string parameters
        $queryString = parse_url($requestedUrl, PHP_URL_QUERY);
        parse_str($queryString, $queryParameters);
        $routeParams = array_merge($routeParams, $queryParameters);
        return $routeParams;
    }
}
