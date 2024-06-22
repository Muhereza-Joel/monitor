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

        // Start a transaction
        $this->database->begin_transaction();

        try {
            $query = "UPDATE indicators SET indicator_title = ?, definition = ?, baseline = ?, target = ?, data_source = ?, frequency = ?, responsible = ?, reporting = ? WHERE id = ?";
            $stmt = $this->database->prepare($query);
            $stmt->bind_param('ssssssssi', $indicator_title, $definition, $baseline, $target, $data_source, $frequency, $responsible, $reporting, $indicator_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Calculate progress for responses
                $progressQuery = "UPDATE responses SET progress = ((current - ?) / (? - ?)) * 100 WHERE indicator_id = ?";
                $progressStmt = $this->database->prepare($progressQuery);
                $progressStmt->bind_param('iiii', $baseline, $target, $baseline, $indicator_id);
                $progressStmt->execute();

                // Commit the transaction
                $this->database->commit();

                $response = ['message' => 'Record Updated Successfully'];
                $httpStatus = 200;

                Request::send_response($httpStatus, $response);
            } elseif ($stmt->affected_rows == 0) {
                $response = ['message' => 'You did not change anything.'];
                $httpStatus = 200;

                Request::send_response($httpStatus, $response);
            } else {
                throw new Exception($stmt->error);
            }
        } catch (Exception $e) {
            // Rollback the transaction on error
            $this->database->rollback();

            $response = ['error' => $e->getMessage()];
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
        $query = "
                SELECT 
                    i.*, 
                    IFNULL(
                        (
                            SELECT 
                                ROUND(
                                    MAX((r.current - i.baseline) / (i.target - i.baseline) * 100), 0
                                ) 
                            FROM responses AS r 
                            WHERE r.indicator_id = i.id
                        ), 
                        0
                    ) AS cumulative_progress,
                    (SELECT COUNT(id) FROM responses WHERE indicator_id = i.id) AS response_count
                FROM 
                    indicators AS i;
            ";

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

    public function get_last_response_current_state($id)
    {
        $query = "SELECT current AS last_current_state
        FROM responses
        WHERE indicator_id = ?
        ORDER BY created_at DESC
        LIMIT 1";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }
    public function get_response($id)
    {
        $query = "SELECT responses.*, indicators.baseline, indicators.target FROM responses
        JOIN indicators ON indicators.id = responses.indicator_id
        WHERE responses.id = ?";

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

        $indicator_id = $request->input('indicator_id');
        $current = $request->input('current');
        $progress = $request->input('progress');
        $notes = $request->input('notes');
        $lessons = $request->input('lessons');
        $recommendations = $request->input('recommendations');
        $user_id = Session::get('user_id');


        $query = "INSERT INTO responses(indicator_id, current, progress, notes, lessons, recommendations, user_id) VALUES(?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('iiisssi', $indicator_id, $current, $progress, $notes, $lessons, $recommendations, $user_id);
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

    public function edit_response()
    {
        $request = Request::capture();

        $response_id = $request->input('response-id');
        $current = $request->input('current');
        $progress = $request->input('progress');
        $notes = $request->input('notes');
        $lessons = $request->input('lessons');
        $recommendations = $request->input('recommendations');


        $query = "UPDATE responses SET current = ?, progress = ?, notes = ?, lessons = ?, recommendations = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('iisssi', $current, $progress, $notes, $lessons, $recommendations, $response_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Row Updated Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => "You din't change anything"];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function update_user_role()
    {
        $request = Request::capture();

        $user_id = $request->input('user_id');
        $role = $request->input('role');

        $query = "UPDATE app_users SET role = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('si', $role, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Role Updated Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => "You din't change anything"];
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
        $query = "CALL GetResponses()";

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
        $query = "CALL GetUserResponses(?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $current_user);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_indicator_responses($indicator_id)
    {
        $query = "CALL GetIndicatorResponses(?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $indicator_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function delete_response($id)
    {
        $query = "DELETE FROM responses WHERE id = ?";

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

    public function create_organisation()
    { 
        $request = Request::capture();

        $organization_logo = $request->input('image_url');
        $organization_name = $request->input('organization-name');
        
        $query = "INSERT INTO organizations(name, logo) VALUES(?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ss', $organization_name, $organization_logo);
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

    public function get_organisations()
    {
        $query = "SELECT * FROM organizations WHERE name <> 'Administrator'";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_indicators_count()
    {
        $count = 0;
        $query = "SELECT COUNT(*) FROM indicators";

        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_responses_count()
    {
        $count = 0;
        $query = "SELECT COUNT(*) FROM responses";

        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_user_responses_count()
    {
        $count = 0;
        $current_user = Session::get('user_id');
        $query = "SELECT COUNT(*) FROM responses WHERE responses.user_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $current_user);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_users_count()
    {
        $count = 0;
        $query = "SELECT COUNT(*) FROM app_users WHERE profile_created = 1";

        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

}
