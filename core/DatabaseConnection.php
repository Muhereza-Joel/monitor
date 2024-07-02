<?php

namespace core;

use Exception;
use mysqli;

class DatabaseConnection
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $app_name;
    private $mysqli;
    private static $instance = null;

    private function __construct($host, $dbname, $username, $password, $charset = 'utf8')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->app_name = getenv("APP_NAME");
        $this->connect();
    }

    public static function getInstance($host, $dbname, $username, $password, $charset = 'utf8')
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $dbname, $username, $password, $charset);
        }
        return self::$instance;
    }

    private function connect()
    {
        $this->mysqli = null;
        try {
            $tempConnection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($tempConnection->connect_error) {
                $this->handleConnectionError($tempConnection->connect_error);
            }
            $this->mysqli = $tempConnection;
        } catch (Exception $e) {
            $this->handleConnectionError($e->getMessage());
        }
    }

    private function handleConnectionError($errorMessage)
    {
        error_log($errorMessage);
        ob_start(); // Start output buffering to prevent any output before redirection
        @ini_set('display_errors', 0); // Suppress PHP errors temporarily
        header('Location: /' . $this->app_name . '/database/connection/error/');
        exit;
    }

    public function get_connection()
    {
        if ($this->mysqli === null) {
            throw new Exception("Attempted to get a database connection before it was established.");
        }
        return $this->mysqli;
    }

    private function __clone()
    {
        // Prevent cloning of the instance
    }

    public function __wakeup()
    {
        // Prevent unserializing of the instance
    }
}
