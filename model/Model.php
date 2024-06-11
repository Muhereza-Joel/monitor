<?php

namespace model;

use core\DatabaseConnection;
use core\Request;
use core\Session;
use Exception;

class Model
{
    private $database;
    private static $instance = null;

    private function __construct()
    {
        $this->get_database_connection();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
        // Prevent cloning of the instance
    }

    public function __wakeup()
    {
        // Prevent unserializing of the instance
    }

    private function get_database_connection()
    {
        $database_connection = DatabaseConnection::getInstance(getenv('DB_HOST'), getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $this->database = $database_connection->get_connection();
    }


    public function get_all_users()
    {
        $query = "SELECT up.*, au.id AS user_id, au.username, au.approved, au.email, au.role
                  FROM app_users au JOIN user_profile up
                  ON au.id = up.user_id";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $users];
    }

    public function get_user_details($id)
    {
        $query = "SELECT up.*, au.id AS user_id, au.username, au.approved, au.email, au.role
                FROM app_users au JOIN user_profile up
                ON au.id = up.user_id
                WHERE up.id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user_details = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $user_details];
    }

    public function check_nin()
    {
        $request = Request::capture();

        $nin = $request->input('nin');

        $query = "SELECT nin FROM voters WHERE nin LIKE ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $nin);
        $stmt->execute();

        $result = $stmt->get_result();
        $nin_exists = $result->fetch_assoc();


        if ($nin_exists) {
            $response = ['message' => 'NIN exists already in the system'];
            $httpStatus = 401;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['message' => 'No body has the same NIN in the system'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        }

        $stmt->close();
    }


    public function create_indicator()
    {
        $request = Request::capture();

        $indicator_title = $request->input('indicator-title');
        $definition = $request->input('definition');
        $baseline = $request->input('baseline');
        $target = $request->input('target');
        $data_source = $request->input('data-source');
        $frequency = $request->input('frequency');
        $responsible = $request->input('responsible');
        $reporting = $request->input('reporting');

        $query = "INSERT INTO indicators(indicator_title, definition, baseline, target, data_source, frequency, responsible, reporting) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssssssss', $indicator_title, $definition, $baseline, $target, $data_source, $frequency, $responsible, $reporting);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Row Created Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function update_indicator()
    {
        $request = Request::capture();

        $indicator_id = $request->input('indicator-id');
        $indicator_title = $request->input('indicator-title');
        $definition = $request->input('definition');
        $baseline = $request->input('baseline');
        $target = $request->input('target');
        $data_source = $request->input('data-source');
        $frequency = $request->input('frequency');
        $responsible = $request->input('responsible');
        $reporting = $request->input('reporting');

        $query = "UPDATE indicators SET indicator_title = ?, definition = ?, baseline = ?, target = ?, data_source = ?, frequency = ?, responsible = ?, reporting = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssssssssi', $indicator_title, $definition, $baseline, $target, $data_source, $frequency, $responsible, $reporting, $indicator_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Record Updated Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'You did not change anything..'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function delete_indicator($id)
    {
        $query = "DELETE FROM indicators WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Record Deleted Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Record Not Found'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function get_all_indicators()
    {
        $query = "SELECT i.*, 
        ROUND(SUM(r.progress) / COUNT(r.indicator_id)) AS cumulative_progress 
        FROM indicators AS i 
        LEFT JOIN responses AS r ON i.id = r.indicator_id 
        GROUP BY i.id";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }



    public function get_indicator($id)
    {
        $query = "SELECT * FROM indicators WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function create_response()
    {
        $request = Request::capture();

        $indicator_id = $request->input('indicator-id');
        $current = $request->input('current');
        $progress = $request->input('progress');
        $lessons = $request->input('lessons');
        $user_id = Session::get('user_id');


        $query = "INSERT INTO responses(indicator_id, current, progress, lessons, user_id) VALUES(?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('iiisi', $indicator_id, $current, $progress, $lessons, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Row Created Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function get_all_responses()
    {
        $query = "SELECT responses.*, indicators.indicator_title, indicators.baseline, indicators.target, user_profile.name FROM responses
        JOIN indicators ON indicators.id = responses.indicator_id
        JOIN user_profile ON user_profile.user_id = responses.user_id
        ORDER BY responses.indicator_id, responses.user_id";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_all_user_responses()
    {
        $current_user = Session::get('user_id');
        $query = "SELECT responses.*, indicators.indicator_title, indicators.baseline, indicators.target, user_profile.name FROM responses
        JOIN indicators ON indicators.id = responses.indicator_id
        JOIN user_profile ON user_profile.user_id = responses.user_id
        WHERE responses.user_id = ?
        ORDER BY responses.indicator_id, responses.user_id";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $current_user);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }
}
