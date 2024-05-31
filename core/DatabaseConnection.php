<?php
namespace core;

use Exception;
use mysqli;

class DatabaseConnection {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $mysqli;
    private static $instance = null;

    private function __construct($host, $dbname, $username, $password, $charset = 'utf8') {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;

        $this->connect();
    }

    public static function getInstance($host, $dbname, $username, $password, $charset = 'utf8') {
        if (self::$instance === null) {
            self::$instance = new self($host, $dbname, $username, $password, $charset);
        }
        return self::$instance;
    }

    private function connect() {
        try {
            $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->mysqli->connect_error) {
                throw new Exception('Connection failed: ' . $this->mysqli->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function get_connection() {
        return $this->mysqli;
    }

    private function __clone() {
        // Prevent cloning of the instance
    }

    private function __wakeup() {
        // Prevent unserializing of the instance
    }
}
?>
