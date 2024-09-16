<?php

namespace core\log;

use core\constants\ActionRegistry;
use core\Registry;
use Ramsey\Uuid\Uuid;

class Logger
{
    private $db;
    private static $instance = null;

    // Private constructor to prevent instantiation
    private function __construct()
    {
        $this->get_database_connection();
    }

    // Static method to get the single instance of Logger
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get the database connection from the Registry
    private function get_database_connection()
    {
        $this->db = Registry::get("database");
    }

    // Method to log an action
    private function log_action($id, $userId, $action, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO user_activity_logs (id, user_id, action, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $id, $userId, $action, $description);
        return $stmt->execute();
    }

    // Methods to log specific actions
    public function log_login($userId)
    {
        $ip = $this->get_user_ip();
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_LOGIN, ActionRegistry::DESCRIPTION_LOGIN . $ip);
    }


    public function log_logout($userId)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_LOGOUT, ActionRegistry::DESCRIPTION_LOGOUT);
    }

    public function log_create($userId, $recordId)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_CREATE, ActionRegistry::DESCRIPTION_CREATE . $recordId);
    }

    public function log_update($userId, $recordId)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_UPDATE, ActionRegistry::DESCRIPTION_UPDATE . $recordId);
    }

    public function log_delete($userId, $recordId)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_DELETE, ActionRegistry::DESCRIPTION_DELETE . $recordId);
    }

    private function get_user_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP from shared internet
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP passed from proxy
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Direct IP address
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    
}
