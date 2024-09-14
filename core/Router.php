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

    public function routeRequest($path, $middlewareClass, $method = 'GET')
    {
        $this->handleRequest($path, $middlewareClass, $method);
    }

    private function handleRequest($requestedUrl, $middlewareClass = null, $method = 'GET')
    {
        // Remove the base URL from the requested URL
        $requestedUrl = str_replace($this->app_base_url, '', $requestedUrl);

        // Check if the user is logged in when accessing the base URL
        if ($requestedUrl === "/" && Session::isLoggedIn()) {
            header("Location: {$this->app_base_url}/dashboard/");
            return;
        }

        // Remove query string parameters from the URL
        $urlParts = explode('?', $requestedUrl);
        $path = $urlParts[0];
        $queryString = isset($urlParts[1]) ? $urlParts[1] : '';

        // Parse query parameters
        parse_str($queryString, $queryParams);

        // Check if the route exists for the given HTTP method
        $matchingRoutes = array_filter($this->routes, function ($route) use ($path, $method) {
            return $this->matchRoute($route['path'], $path) && in_array($method, $route['methods']);
        });

        if (!empty($matchingRoutes)) {
            $route = reset($matchingRoutes);
            // Split the controller and method
            list($controllerName, $methodName) = explode('@', $route['controllerMethod']);
            // Apply middleware if provided
            if ($middlewareClass !== null) {
                $this->applyMiddlewareLogic($middlewareClass, $path, $controllerName, $methodName, $queryParams);
            } else {
                // No middleware, proceed with regular route logic
                $this->handleRegularRouteLogic($path, $controllerName, $methodName, $queryParams);
            }
        } else {
            // If the route is not found, return a 404 response
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
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

    private function applyMiddlewareLogic($middlewareClass, $path, $controllerName, $methodName, $queryParams)
    {
        // Create an instance of the middleware
        $middleware = new $middlewareClass();
        // Check if the middleware allows access
        if ($middleware->handle()) {
            // Continue with regular route logic
            $this->handleRegularRouteLogic($path, $controllerName, $methodName, $queryParams);
        } else {
            // Handle unauthorized access (e.g., redirect to login page)
            header("Location: {$this->app_base_url}/auth/login/");
            exit();
        }
    }

    private function handleRegularRouteLogic($path, $controllerName = null, $methodName = null, $queryParams = [])
    {
        // Find the route that matches the specified path
        $matchingRoute = null;
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route['path'], $path)) {
                $matchingRoute = $route;
                break;
            }
        }

        // Check if a matching route was found
        if ($matchingRoute !== null) {
            // Extract individual details
            $controllerMethod = $matchingRoute['controllerMethod'];
            $methods = $matchingRoute['methods'];
            // Check if the request method is allowed
            if (in_array($_SERVER['REQUEST_METHOD'], $methods)) {
                // Split the controller and method
                list($controllerName, $methodName) = explode('@', $controllerMethod);
                if (!empty($controllerName) && class_exists($controllerName)) {
                    $controller = new $controllerName();
                    // Extract route parameters from the URL
                    $routeParams = $this->extractRouteParameters($matchingRoute['path'], $path);
                    // Merge route parameters and query parameters
                    $params = array_merge($routeParams, $queryParams);

                    // Ensure parameters are passed correctly as named parameters
                    try {
                        $reflectionMethod = new \ReflectionMethod($controller, $methodName);
                        $args = [];
                        foreach ($reflectionMethod->getParameters() as $param) {
                            $paramName = $param->getName();
                            if (array_key_exists($paramName, $params)) {
                                $args[$paramName] = $params[$paramName];
                            } else {
                                // Handle optional parameters
                                if ($param->isOptional()) {
                                    $args[$paramName] = $param->getDefaultValue();
                                } else {
                                    throw new \Exception("Missing required parameter \$$paramName");
                                }
                            }
                        }

                        // Call the controller method and pass parameters
                        $reflectionMethod->invokeArgs($controller, $args);
                    } catch (\Exception $e) {
                        // Handle error, log it or return a proper response
                        header("HTTP/1.0 500 Internal Server Error");
                        echo "Error: " . $e->getMessage();
                    }
                }
            } else {
                // If the request method is not allowed, return a 404 response
                header("HTTP/1.0 404 Not Found");
                echo "404 Not Found";
            }
        } else {
            // If the route is not found, return a 404 response
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }
}
