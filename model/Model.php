<?php

namespace model;

use core\DatabaseConnection;
use core\Request;
use core\Session;
use Exception;
use Ramsey\Uuid\Uuid;

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
        $query = "";
        $params = [];
        $types = "";

        if (Session::get('my_organization_name') == 'Administrator') {
            $query = "SELECT up.*, au.id AS user_id, au.username, au.approved, au.email, au.role
                  FROM app_users au JOIN user_profile up
                  ON au.id = up.user_id";
        } else {
            $query = "SELECT up.*, au.id AS user_id, au.username, au.approved, au.email, au.role
                  FROM app_users au JOIN user_profile up
                  ON au.id = up.user_id 
                  WHERE up.organization_id = ?";
            $organization_id = Session::get('selected_organisation_id');
            $params[] = $organization_id;
            $types .= "s";
        }

        $stmt = $this->database->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

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
        $stmt->bind_param("s", $id);
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

        $id = Uuid::uuid4()->toString();
        $indicator_title = $request->input('indicator-title');
        $definition = $request->input('definition');
        $baseline = $request->input('baseline');
        $target = $request->input('target');
        $data_source = $request->input('data-source');
        $frequency = $request->input('frequency');
        $responsible = $request->input('responsible');
        $reporting = $request->input('reporting');
        $organization_id = Session::get('my_organization_id');

        $query = "INSERT INTO indicators(id, indicator_title, definition, baseline, target, data_source, frequency, responsible, reporting, organization_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssssssssss', $id, $indicator_title, $definition, $baseline, $target, $data_source, $frequency, $responsible, $reporting, $organization_id);
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
            $stmt->bind_param('sssssssss', $indicator_title, $definition, $baseline, $target, $data_source, $frequency, $responsible, $reporting, $indicator_id);
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
        $stmt->bind_param('s', $id);
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
                    indicators AS i
                WHERE organization_id = ?
                ORDER BY i.status, i.created_at;
            ";

        $organization_id = Session::get('selected_organisation_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_all_archived_indicators()
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
                            FROM responses_archive AS r 
                            WHERE r.indicator_id = i.id
                        ), 
                        0
                    ) AS cumulative_progress,
                    (SELECT COUNT(id) FROM responses_archive WHERE indicator_id = i.id) AS response_count
                FROM 
                    indicators_archive AS i
                WHERE organization_id = ?
                ORDER BY i.status;
            ";

        $organization_id = Session::get('selected_organisation_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
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
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function update_indicator_status($id, $status)
    {
        $this->database->begin_transaction();

        try {
            // Update indicator status
            $query = "UPDATE indicators SET status = ? WHERE id = ?";
            $stmt = $this->database->prepare($query);
            $stmt->bind_param('ss', $status, $id);
            $stmt->execute();

            // Check if the indicator update was successful
            if ($stmt->affected_rows > 0) {
                // Update related responses' status
                $query = "UPDATE responses SET status = ? WHERE indicator_id = ?";
                $stmt = $this->database->prepare($query);
                $stmt->bind_param('ss', $status, $id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $this->database->commit();
                    $response = ['message' => 'Indicator and related responses updated successfully'];
                    $httpStatus = 200;
                } else {
                    // No responses to update, but indicator status update was successful
                    $this->database->commit();
                    $response = ['message' => 'Indicator status updated, but no related responses found'];
                    $httpStatus = 200;
                }

                Request::send_response($httpStatus, $response);
            } elseif ($stmt->affected_rows == 0) {
                $this->database->rollback();
                $response = ['message' => "You didn't change anything"];
                $httpStatus = 200;

                Request::send_response($httpStatus, $response);
            } else {
                throw new Exception($stmt->error);
            }
        } catch (Exception $e) {
            $this->database->rollback();
            $response = ['error' => $e->getMessage()];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function get_last_response_current_state($id)
    {
        $query = "SELECT current AS last_current_state
        FROM responses
        WHERE indicator_id = ?
        ORDER BY created_at DESC
        LIMIT 1";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $id);
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
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function create_response()
    {
        $request = Request::capture();

        $id = Uuid::uuid4()->toString();
        $indicator_id = $request->input('indicator_id');
        $current = $request->input('current');
        $progress = $request->input('progress');
        $notes = $request->input('notes');
        $lessons = $request->input('lessons');
        $recommendations = $request->input('recommendations');
        $user_id = Session::get('user_id');
        $organization_id = Session::get('my_organization_id');

        $query = "INSERT INTO responses(id, indicator_id, current, progress, notes, lessons, recommendations, user_id, organization_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssiisssss', $id, $indicator_id, $current, $progress, $notes, $lessons, $recommendations, $user_id, $organization_id);
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
        $stmt->bind_param('iissss', $current, $progress, $notes, $lessons, $recommendations, $response_id);
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
        $stmt->bind_param('ss', $role, $user_id);
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
        $organization_id = Session::get('selected_organisation_id');

        $query = "CALL GetResponses(?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function archive_indicators()
    {

        $organization_id = Session::get('my_organization_id');

        $query = "CALL ArchiveOrganisationData(?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
        $stmt->execute();

        $response = ['message' => 'All public and archived indicators moved to archives successfully.y'];
        $httpStatus = 200;

        Request::send_response($httpStatus, $response);
    }

    public function get_all_archived_responses()
    {
        $organization_id = Session::get('selected_organisation_id');

        $query = "CALL GetAllArchivedResponses(?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
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
        $stmt->bind_param('s', $current_user);
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
        $stmt->bind_param('s', $indicator_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_indicator_archived_responses($indicator_id)
    {
        $query = "CALL GetIndicatorArchivedResponses(?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $indicator_id);
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
        $stmt->bind_param('s', $id);
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

    public function add_files($response_id, $file_infos_json)
    {
        // Retrieve the current file info from the database
        $query = "SELECT files FROM responses WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $response_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_files = json_decode($row['files'], true);

            // Check if existing files is an array, if not initialize it
            if (!is_array($existing_files)) {
                $existing_files = [];
            }

            // Decode the new file info
            $new_files_array = json_decode($file_infos_json, true);
            // Append new file info to the existing array
            $updated_files = array_merge($existing_files, $new_files_array);

            // Encode the updated array back to JSON
            $updated_files_json = json_encode(array_values($updated_files));

            // Update the database with the new file info
            $update_query = "UPDATE responses SET files = ? WHERE id = ?";
            $update_stmt = $this->database->prepare($update_query);
            $update_stmt->bind_param('ss', $updated_files_json, $response_id);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                $response = ['message' => 'Files added successfully'];
                $httpStatus = 200;
            } elseif ($update_stmt->affected_rows == 0) {
                $response = ['message' => 'You did not change anything'];
                $httpStatus = 200;
            } else {
                $response = ['error' => $update_stmt->error];
                $httpStatus = 500;
            }
        } else {
            $response = ['error' => 'Response not found'];
            $httpStatus = 404;
        }

        Request::send_response($httpStatus, $response);
    }

    public function remove_file($response_id, $file_id)
    {
        // Retrieve the current file info from the database
        $query = "SELECT files FROM responses WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $response_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_files = json_decode($row['files'], true);

            // Check if existing files is an array, if not initialize it
            if (!is_array($existing_files)) {
                $existing_files = [];
            }

            // Remove the file with the specified ID
            $updated_files = array_filter($existing_files, function ($file) use ($file_id) {
                return $file['id'] !== $file_id;
            });

            // Encode the updated array back to JSON
            $updated_files_json = json_encode(array_values($updated_files));

            // Update the database with the new file info
            $update_query = "UPDATE responses SET files = ? WHERE id = ?";
            $update_stmt = $this->database->prepare($update_query);
            $update_stmt->bind_param('ss', $updated_files_json, $response_id);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                $response = ['message' => 'File removed successfully'];
                $httpStatus = 200;
            } elseif ($update_stmt->affected_rows == 0) {
                $response = ['message' => 'File not found'];
                $httpStatus = 200;
            } else {
                $response = ['error' => $update_stmt->error];
                $httpStatus = 500;
            }
        } else {
            $response = ['error' => 'Response not found'];
            $httpStatus = 404;
        }

        Request::send_response($httpStatus, $response);
    }

    public function get_files($response_id)
    {
        // Retrieve the current file info from the database
        $query = "SELECT files FROM responses WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $response_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $files_json = $row['files'];

            // Decode the JSON-encoded file info
            $files = json_decode($files_json, true);

            // Check if the decoded data is an array
            if (is_array($files)) {
                $response = ['files' => $files];
                $httpStatus = 200;
            } else {
                $response = ['message' => 'No files found or invalid data format'];
                $httpStatus = 404;
            }
        } else {
            $response = ['error' => 'Response not found'];
            $httpStatus = 404;
        }

        // Send the response
        Request::send_response($httpStatus, $response);
    }

    public function get_archived_response_files($response_id)
    {
        // Retrieve the current file info from the database
        $query = "SELECT files FROM responses_archive WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $response_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $files_json = $row['files'];

            // Decode the JSON-encoded file info
            $files = json_decode($files_json, true);

            // Check if the decoded data is an array
            if (is_array($files)) {
                $response = ['files' => $files];
                $httpStatus = 200;
            } else {
                $response = ['message' => 'No files found or invalid data format'];
                $httpStatus = 404;
            }
        } else {
            $response = ['error' => 'Response not found'];
            $httpStatus = 404;
        }

        // Send the response
        Request::send_response($httpStatus, $response);
    }

    public function create_organisation()
    {
        $request = Request::capture();

        $id = Uuid::uuid4()->toString();
        $organization_logo = $request->input('image_url');
        $organization_name = $request->input('organization-name');

        $query = "INSERT INTO organizations(id, name, logo) VALUES(?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('sss', $id, $organization_name, $organization_logo);
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
        $query = "SELECT * FROM organizations WHERE name <> 'Administrator' ORDER BY created_at ASC";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_organisation_details($id)
    {
        $query = "SELECT * FROM organizations WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function update_organisation()
    {
        $request = Request::capture();

        $organization_logo = $request->input('image_url');
        $organization_id = $request->input('organisation-id');
        $organization_name = $request->input('organization-name');
        $status = $request->input('active');

        $query = "UPDATE organizations SET name = ?, active = ?, logo = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssss', $organization_name, $status, $organization_logo, $organization_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Organisation Details Updated Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'You did not change anything'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }

    public function create_event()
    {
        $request = Request::capture();

        $id = Uuid::uuid4()->toString();
        $event_title = $request->input('event');
        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        $organization_id = Session::get('selected_organisation_id');
        $user_id = Session::get('user_id');
        $event_status = $request->input('active');
        $event_visibility = $request->input('visibility');

        $query = "INSERT INTO events(id, event, start_date, end_date, organisation_id, user_id, active, viewer) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssssssss', $id, $event_title, $start_date, $end_date, $organization_id, $user_id, $event_status, $event_visibility);
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


    public function get_events($visibility, $active)
    {
        $organisation_id = Session::get('selected_organisation_id');

        $query = "SELECT events.event AS title, events.start_date AS start, events.end_date AS end, organizations.logo, events.viewer 
                  FROM events 
                  LEFT JOIN organizations ON events.organisation_id = organizations.id 
                  WHERE events.organisation_id = ? AND events.active = ? AND events.viewer = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('sis', $organisation_id, $active, $visibility);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_my_organisation_events($visibility)
    {
        $organisation_id = Session::get('my_organization_id');

        // Base query
        $query = "SELECT events.id, events.event AS title, events.start_date AS start, events.end_date AS end, organizations.logo, events.viewer, events.active, events.created_at
              FROM events 
              JOIN organizations ON events.organisation_id = organizations.id 
              WHERE events.organisation_id = ?";

        // Add visibility filter
        if ($visibility === 'all' || $visibility === 'internal' || $visibility === 'external') {
            $query .= " AND events.viewer = ?";
        }

        $stmt = $this->database->prepare($query);

        // Bind parameters
        if ($visibility === 'all' || $visibility === 'internal' || $visibility === 'external') {
            $stmt->bind_param('ss', $organisation_id, $visibility);
        } else {
            $stmt->bind_param('s', $organisation_id);
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function delete_event($id)
    {
        $query = "DELETE FROM events WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $id);
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

    public function get_event($id)
    {
        $query = "SELECT * FROM events WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function update_event()
    {
        $request = Request::capture();

        $event_id = $request->input('id');
        $event_title = $request->input('event');
        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        $event_status = $request->input('active');
        $event_visibility = $request->input('visibility');

        $query = "UPDATE events SET event = ?, start_date = ?, end_date = ?, active = ?, viewer = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssssss', $event_title, $start_date, $end_date, $event_status, $event_visibility, $event_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Record Updated Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => "You didn't change anything"];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => $stmt->error];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }


    public function get_indicators_count()
    {
        $count = 0;
        $organization_id = Session::get('selected_organisation_id');

        $query = "SELECT COUNT(*) FROM indicators WHERE indicators.organization_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_responses_count()
    {
        $count = 0;
        $organization_id = Session::get('selected_organisation_id');

        $query = "SELECT COUNT(*) FROM responses WHERE responses.organization_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
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
        $selected_organization_id = Session::get('selected_organisation_id');
        $query = "SELECT COUNT(*) FROM responses WHERE responses.user_id = ? AND responses.organization_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ss', $current_user, $selected_organization_id);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_users_count()
    {
        $count = 0;
        $organization_id = Session::get('selected_organisation_id');
        $query = "SELECT COUNT(*) FROM app_users WHERE profile_created = 1 AND app_users.organization_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_public_and_archived_indicators_count()
    {
        $count = 0;
        $organization_id = Session::get('my_organization_id');
        $query = "SELECT COUNT(*) FROM indicators WHERE status = 'public' OR status = 'archived' AND indicators.organization_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $organization_id);
        $stmt->execute();
        $stmt->bind_result($count);

        $stmt->fetch();

        $stmt->close();

        return $count;
    }

    public function get_selected_organisation_logo($id)
    {
        $logo = "";
        $query = "SELECT logo FROM organizations WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($logo);

        $stmt->fetch();

        $stmt->close();

        return $logo;
    }
}
