<?php

namespace core;

class Registry
{

    private static $instances = [];

    //Prevent Instantiation
    private function __construct() {}

    // Get an instance from the registry
    public static function get($key)
    {
        if (isset(self::$instances[$key])) {
            return self::$instances[$key];
        }
        throw new \Exception("No instance found in registry for key: $key");
    }

    // Store an instance in the registry
    public static function set($key, $instance)
    {
        self::$instances[$key] = $instance;
    }

    // Check if an instance exists in the registry
    public static function has($key)
    {
        return isset(self::$instances[$key]);
    }
}
