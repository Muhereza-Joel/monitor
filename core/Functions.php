<?php

use core\Registry;
use core\Route;
use core\Session;

if (!function_exists('url')) {
    /**
     * Generate a URL for a given path.
     *
     * @param string $path         The relative path to append to the base URL.
     * @param array  $queryParams  Optional associative array of query parameters to include in the URL.
     * @param bool   $includeLocale Optional flag to include the locale in the URL.
     * @return string              The full URL for the given path.
     */
    function url($path = '', $queryParams = [], $includeLocale = false)
    {
        // Get the base URL from environment variables
        $baseUrl = getenv("APP_BASE_URL");

        // Get the current locale and append it to the base URL if $includeLocale is true
        $locale = $includeLocale ? current_locale() . '/' : '';

        // Build the URL by adding the locale at the beginning after the base URL
        $url = rtrim($baseUrl, '/') . '/' . $locale . ltrim($path, '/');

        // If there are query parameters, append them as a query string
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        return $url;
    }
}



if (!function_exists('set_locale')) {
    /**
     * Set the current locale in the session.
     *
     * @param string $locale
     * @return void
     */
    function set_locale($locale)
    {
        // Validate and set the locale
        $availableLocales = Registry::get('locales');
        if (in_array($locale, $availableLocales)) {
            Session::set('locale', $locale);
        } else {
            // Fallback to default locale if invalid
            Session::set('locale', 'en');
        }
    }
}

if (!function_exists('get_locale')) {
    /**
     * Get the current locale from the session.
     *
     * @return string
     */
    function get_locale()
    {
        return Session::get('locale', 'en'); // Default to 'en'
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get the current locale for use in URLs and other purposes.
     *
     * @return string
     */
    function current_locale()
    {
        return get_locale();
    }
}

if (!function_exists('__')) {
    /**
     * Translate a message based on the current locale.
     *
     * @param string $key
     * @param array $replace
     * @param string|null $locale
     * @return string
     */
    function __($key, array $replace = [], $locale = null)
    {
        $locale = $locale ?? current_locale();
        $filePath = __DIR__ . "/../core/lang/{$locale}.php";

        if (file_exists($filePath)) {
            $translations = include $filePath;
            $message = $translations[$key] ?? $key; // Fallback to key if translation is not found

            // Replace placeholders in the translation
            foreach ($replace as $search => $value) {
                $message = str_replace("{{ $search }}", $value, $message);
            }

            return $message;
        }

        return $key; // Fallback to key if locale file doesn't exist
    }
}


if (!function_exists('trans')) {
    /**
     * Translate a message based on the current locale using the __() function.
     *
     * @param string $key
     * @param array $replace
     * @param string|null $locale
     * @return string
     */
    function trans($key, array $replace = [], $locale = null)
    {
        return __($key, $replace, $locale);
    }
}

if (!function_exists('route')) {
    /**
     * Generate a URL for a named route.
     *
     * @param string $name The name of the route.
     * @param array  $parameters Optional array of parameters to pass to the route.
     * @param string|null $locale Optional locale to include in the URL.
     * @return string The generated URL for the named route.
     */
    function route($name, $parameters = [], $locale = false)
    {
        // Get the route path by name
        $routePath = Route::getNamedRoute($name);

        // Replace route placeholders (e.g., {id}, {slug}) with actual parameters
        foreach ($parameters as $key => $value) {
            $routePath = str_replace('{' . $key . '}', $value, $routePath);
        }

        // Remove any prefix from the route path
        $prefix = rtrim(Route::getPrefix(), '/');
        if ($prefix && strpos($routePath, $prefix) === 0) {
            $routePath = substr($routePath, strlen($prefix));
        }

        // Ensure path does not include base URL
        $baseUrl = rtrim(env('APP_BASE_URL', ''), '/');
        $routePath = ltrim($routePath, '/'); // Remove leading slash if any

        // Get the locale if provided
        if ($locale) {
            $locale = rtrim(get_locale(), '/');
            return $baseUrl ? $baseUrl . '/' . $locale . '/' . $routePath : '/' . $locale . '/' . $routePath;
        }

        return $baseUrl ? $baseUrl . '/' . $routePath : $routePath;
    }
}


if (!function_exists('redirect')) {
    /**
     * Redirect to a given path with optional flash messages.
     *
     * @param string $path          The path to redirect to.
     * @param array  $flashMessages An associative array of flash messages to set in the session.
     * @param int    $statusCode    The HTTP status code for the redirect (default: 302).
     * @return void
     */
    function redirect($path, array $flashMessages = [], $statusCode = 302)
    {
        foreach ($flashMessages as $key => $message) {
            set_flash_message($key, $message);
        }

        header("Location: " . url($path), true, $statusCode);
        exit();
    }
}

if (!function_exists('set_flash_message')) {
    /**
     * Set a flash message in the session.
     *
     * @param string $key     The key under which to store the flash message.
     * @param string $message The flash message to store.
     * @return void
     */
    function set_flash_message($key, $message)
    {
        Session::set_flash_message($key, $message);
    }
}

if (!function_exists('get_flash_message')) {
    /**
     * Get a flash message from the session.
     *
     * @param string $key The key of the flash message to retrieve.
     * @return string|null The flash message or null if it doesn't exist.
     */
    function get_flash_message($key)
    {
        return Session::get_flash_message($key);
    }
}

if (!function_exists('asset')) {
    /**
     * Generate a URL for an asset (e.g., CSS, JS, images).
     *
     * @param string $path The relative path to the asset file.
     * @return string      The full URL for the asset.
     */
    function asset($path)
    {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get or generate a CSRF token.
     *
     * @return string The CSRF token.
     */
    function csrf_token()
    {
        if (!Session::get('csrf_token')) {
            $token = bin2hex(random_bytes(32));
            Session::set('csrf_token', $token);
        }

        return Session::get('csrf_token');
    }
}

if (!function_exists('old')) {
    /**
     * Retrieve old input data from the session.
     *
     * @param string $key     The key of the input data.
     * @param string $default The default value to return if the key doesn't exist (default: '').
     * @return string The old input data or the default value.
     */
    function old($key, $default = '')
    {
        return Session::get('old_input')[$key] ?? $default;
    }
}

if (!function_exists('env')) {
    /**
     * Retrieve an environment variable or return a default value.
     *
     * @param string $key     The environment variable key.
     * @param mixed  $default The default value to return if the variable is not set (default: null).
     * @return mixed          The value of the environment variable or the default value.
     */
    function env($key, $default = null)
    {
        return getenv($key) ?: $default;
    }
}

if (!function_exists('auth')) {
    /**
     * Get the currently authenticated user.
     *
     * @return mixed The authenticated user object or null if no user is logged in.
     */
    function auth()
    {
        return Session::get('user');
    }
}

if (!function_exists('response')) {
    /**
     * Send a response with custom content, status code, and headers.
     *
     * @param string $content  The content to return in the response.
     * @param int    $status   The HTTP status code (default: 200).
     * @param array  $headers  An associative array of HTTP headers to send (default: empty).
     * @return void
     */
    function response($content = '', $status = 200, $headers = [])
    {
        http_response_code($status);

        foreach ($headers as $key => $value) {
            header("$key: $value");
        }

        echo $content;
        exit();
    }
}

if (!function_exists('back')) {
    /**
     * Redirect back to the previous URL with optional flash messages.
     *
     * @param array $flashMessages An associative array of flash messages to set in the session (default: empty).
     * @return void
     */
    function back(array $flashMessages = [])
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        redirect($referer, $flashMessages);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the given variables and stop script execution.
     *
     * @param mixed ...$vars The variables to dump.
     * @return void
     */
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        exit();
    }
}

if (!function_exists('session')) {
    /**
     * Get or set a session value.
     *
     * @param string|null $key     The session key to retrieve (optional).
     * @param mixed       $default The default value if the key doesn't exist (optional).
     * @return mixed               The session value or a Session object if no key is provided.
     */
    function session($key = null, $default = null)
    {
        if ($key) {
            return Session::get($key, $default);
        }

        return new Session(); // Return the Session object for other operations
    }
}

if (!function_exists('view')) {
    /**
     * Render a view with the given data.
     *
     * @param string $path The path to the view file.
     * @param array  $data An associative array of data to pass to the view (default: empty).
     * @return void
     */
    function view($path, $data = [])
    {
        extract($data); // Make $data available to the view
        include __DIR__ . "/../views/{$path}.php"; // Adjust the path to your view directory
    }
}

if (!function_exists('abort')) {
    /**
     * Abort the request with a given HTTP status code and message.
     *
     * @param int    $statusCode The HTTP status code (default: 404).
     * @param string $message    The message to display (default: 'Not Found').
     * @return void
     */
    function abort($statusCode = 404, $message = 'Not Found')
    {
        http_response_code($statusCode);
        echo $message;
        exit();
    }
}

if (!function_exists('logger')) {
    /**
     * Log a message to the application's log file.
     *
     * @param string $message The message to log.
     * @return void
     */
    function logger($message)
    {
        $logFile = __DIR__ . '/../logs/app.log'; // Define the log file path
        file_put_contents($logFile, date('Y-m-d H:i:s') . ": $message" . PHP_EOL, FILE_APPEND);
    }
}
