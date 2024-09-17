<?php

namespace core;

class Session
{
    /**
     * Starts a session with secure settings.
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_name(getenv('APP_NAME'));
            // Secure session configuration
            session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'Strict']);
            session_start();
            // Regenerate session ID upon login for added security
            if (!isset($_SESSION['initialized'])) {
                session_regenerate_id();
                $_SESSION['initialized'] = true;
            }
        }
    }

    /**
     * Sets a session variable.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a session variable.
     *
     * @param string $key
     * @param mixed $default Default value if the session key does not exist.
     * @return mixed
     */

    public static function get(string $key, $default = null)
    {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Removes a session variable.
     *
     * @param string $key
     */
    public static function remove(string $key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Destroys the session securely.
     */
    public static function destroy()
    {
        self::start();
        // Clear session array
        $_SESSION = [];
        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        // Finally, destroy the session
        session_destroy();
    }


    public static function isLoggedIn()
    {
        self::start();
        return isset($_SESSION['user_id']);
    }

    // Flash message methods
    public static function set_flash_message($key, $message)
    {
        self::start();
        $_SESSION['flash_messages'][$key] = $message;
    }

    public static function get_flash_message($key)
    {
        self::start();
        if (isset($_SESSION['flash_messages'][$key])) {
            $message = $_SESSION['flash_messages'][$key];
            unset($_SESSION['flash_messages'][$key]); // Remove the message after it's retrieved
            return $message;
        }
        return null;
    }
}
