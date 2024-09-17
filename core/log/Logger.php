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
    private function log_action($id, $userId, $action, $description, $ip_address = null, $record_id = null, $related_table = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO user_activity_logs (id, user_id, action, description, ip_address, record_id, related_table)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssssss", $id, $userId, $action, $description, $ip_address, $record_id, $related_table);
        return $stmt->execute();
    }

    // Methods to log specific actions
    public function log_login($userId)
    {
        $ip = $this->get_user_ip();
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_LOGIN, ActionRegistry::DESCRIPTION_LOGIN . $ip, $ip);
    }

    public function log_logout($userId)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_LOGOUT, ActionRegistry::DESCRIPTION_LOGOUT);
    }

    public function log_create($userId, $recordId, $relatedTable)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_CREATE, ActionRegistry::DESCRIPTION_CREATE . $recordId, null, $recordId, $relatedTable);
    }

    public function log_update($userId, $recordId, $relatedTable)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_UPDATE, ActionRegistry::DESCRIPTION_UPDATE . $recordId, null, $recordId, $relatedTable);
    }

    public function log_delete($userId, $recordId, $relatedTable)
    {
        $id = Uuid::uuid4()->toString();
        $this->log_action($id, $userId, ActionRegistry::ACTION_DELETE, ActionRegistry::DESCRIPTION_DELETE . $recordId, null, $recordId, $relatedTable);
    }

    // Helper method to get the user's IP address
    private function get_user_ip()
    {
        $ip = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Anonymize the IP address (for both IPv4 and IPv6)
        return $this->anonymize_ip($ip);
    }

    private function anonymize_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            // For IPv4, replace the last octet with 0
            return preg_replace('/\.\d+$/', '.0', $ip);
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            // For IPv6, replace the last section with ::0
            return preg_replace('/:[0-9a-f]+$/i', ':0', $ip);
        }

        return $ip;  // Return the original IP if it's invalid or cannot be masked
    }
}
