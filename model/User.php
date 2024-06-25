<?php

namespace model;

use controller\MailController;
use core\DatabaseConnection;
use core\Request;
use core\Session;

class User
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

    public function check_password($password)
    {
        $new_user = new User();
        $user = $new_user->get_user(Session::get('username'), Session::get('email'));

        if ($user && password_verify($password, $user['password'])) {
            $response = ['message' => 'Password matches your current password'];
            $httpStatus = 200;
            Request::send_response($httpStatus, $response);
        } else {
            $response = ['message' => 'Password does not match your current password'];
            $httpStatus = 401;
            Request::send_response($httpStatus, $response);
        }
    }


    public  function login()
    {
        $request = Request::capture();

        $username = $request->input('username');
        $password = $request->input('password');

        if (!empty($username) && !empty($password)) {

            $new_user = new User();
            $user = $new_user->get_user($username, $username);

            if ($user && password_verify($password, $user['password'])) {
                Session::start();
                if ($user['profile_created'] == true) {
                    $user_data = $this->get_user_data($user['id']);
                    $result = $this->get_user_organisation($user['id']);
                    $organization_data = $result['response'];

                    Session::set('user_id', $user['id']);
                    Session::set('my_organization_id', $user['organization_id']);
                    Session::set('my_organization_name', $organization_data['name']);
                    Session::set('username', $user['username']);
                    Session::set('email', $user['email']);
                    Session::set('avator', $user_data['image_url']);
                    Session::set('role', $user['role']);
                } else {
                    Session::set('user_id', $user['id']);
                    Session::set('my_organization_id', $user['organization_id']);
                    Session::set('username', $user['username']);
                    Session::set('email', $user['email']);
                    Session::set('role', $user['role']);
                }


                $response = [
                    'message' => 'Authentication successful',
                    'role' => $user['role'],
                    'profileCreated' => $user['profile_created'],
                    'username' => $user['username'],
                    'approved' => $user['approved'],
                    'user_id' => Session::get('user_id'),
                ];
                $httpStatus = 200;
            } else {

                // Authentication failed
                $response = ['message' => 'Wrong username or password, try again'];
                $httpStatus = 401;
            }
        }

        Request::send_response($httpStatus, $response);
    }

    private function get_user($username, $email)
    {

        $query = "SELECT * FROM app_users WHERE username = ? OR email = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        return $user;
    }

    public function get_user_data($id)
    {
        $query = "SELECT * FROM user_profile WHERE user_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user_profile = $result->fetch_assoc();

        $stmt->close();

        return $user_profile;
    }

    public function get_all_user_data($id)
    {

        $query = "SELECT app_users.username, app_users.email, app_users.role, user_profile.* 
        FROM user_profile 
        JOIN app_users ON app_users.id = user_profile.user_id
        WHERE app_users.id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user_profile = $result->fetch_assoc();

        $stmt->close();

        return $user_profile;
    }

    public function get_user_organisation($id)
    {
        $query = "SELECT organizations.* FROM organizations
        JOIN app_users ON app_users.organization_id = organizations.id
        WHERE app_users.id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function add_user()
    {
        $request = Request::capture();

        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $role = $request->input('role', 'Viewer');
        $organization_id = Session::get('my_organization_id') || Session::get('selected_organisation_id');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $new_user = new User();
        $user = $new_user->get_user($username, $email);

        if ($user) {
            $response = ['message' => 'Username or email already taken..'];
            $httpStatus = 401;

            Request::send_response($httpStatus, $response);
        }

        if (!$user) {
            $query = "INSERT INTO app_users(username, email, password, role, organization_id) VALUES(?, ?, ?, ?, ?)";

            $stmt = $this->database->prepare($query);
            $stmt->bind_param("ssssi", $username, $email, $hashed_password, $role, $organization_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = ['message' => 'Account created successfully.'];
                $httpStatus = 200;

                Request::send_response($httpStatus, $response);
            } else {
                $response = ['error' => $stmt->error];
                $httpStatus = 500;

                Request::send_response($httpStatus, $response);
            }
        }
    }

    public function add_organisation_user()
    {
        $request = Request::capture();

        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $role = $request->input('role', 'Viewer');
        $organization_id = $request->input('organisation');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $new_user = new User();
        $user = $new_user->get_user($username, $email);

        if ($user) {
            $response = ['message' => 'Username or email already taken..'];
            $httpStatus = 401;

            Request::send_response($httpStatus, $response);
        }

        if (!$user) {
            $query = "INSERT INTO app_users(username, email, password, role, organization_id) VALUES(?, ?, ?, ?, ?)";

            $stmt = $this->database->prepare($query);
            $stmt->bind_param("ssssi", $username, $email, $hashed_password, $role, $organization_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = ['message' => 'Account created successfully.'];
                $httpStatus = 200;

                Request::send_response($httpStatus, $response);
            } else {
                $response = ['error' => $stmt->error];
                $httpStatus = 500;

                Request::send_response($httpStatus, $response);
            }
        }
    }

    public function check_email()
    {
        $request = Request::capture();

        $email = $request->input('email');

        $query = "SELECT email FROM app_users WHERE email LIKE ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $email_exists = $result->fetch_assoc();


        if ($email_exists) {
            $response = ['message' => 'Email exists already in the system'];
            $httpStatus = 401;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['message' => 'No body has the same email in the system'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        }

        $stmt->close();
    }

    public function check_nin()
    {
        $request = Request::capture();

        $nin = $request->input('nin');

        $query = "SELECT nin FROM user_profile WHERE nin LIKE ?";

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

    public function save_profile()
    {


        $request = Request::capture();

        $image_url = $request->input('image_url');
        $fullname = $request->input('fullName');
        $nin = $request->input('nin');
        $country = $request->input('country');
        $district = $request->input('district');
        $village = $request->input('village');
        $phone = $request->input('phone');
        $dob = $request->input('dob');
        $gender = $request->input('gender');
        $about = $request->input('about');
        $company = $request->input('company');
        $job = $request->input('job');

        $user_id = Session::get('user_id');
        $organization_id = Session::get('my_organization_id');

        $insert_query = "INSERT INTO user_profile(name, nin, dob, gender, about, company, job, country, district, village, phone, image_url, user_id, organization_id)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Begin transaction
        $this->database->begin_transaction();

        // Prepare insert query
        $stmt = $this->database->prepare($insert_query);

        if ($stmt === false) {
            // Handle prepare error
            $error_message = "Prepare failed: " . $this->database->error;
            error_log($error_message);
            $this->database->rollback();
            Request::send_response(401, 'Failed to prepare insert query');
            return;
        }

        // Bind parameters
        $bind_result = $stmt->bind_param("ssssssssssssii", $fullname, $nin, $dob, $gender, $about, $company, $job, $country, $district, $village, $phone, $image_url, $user_id, $organization_id);
        if ($bind_result === false) {
            // Handle bind_param error
            $error_message = "Bind param failed: " . $stmt->error;
            error_log($error_message);
            $stmt->close();
            $this->database->rollback();
            Request::send_response(401, 'Failed to bind parameters');
            return;
        }

        // Execute insert query
        $execute_result = $stmt->execute();
        if ($execute_result === false) {
            // Handle execute error
            $error_message = "Execute failed: " . $stmt->error;
            $this->database->rollback();
            Request::send_response(401, $error_message);
            $stmt->close();
            return;
        }

        // Check if rows were affected
        if ($stmt->affected_rows > 0) {
            // Prepare update query
            $stmt2 = $this->database->prepare("UPDATE app_users SET profile_created = 1 WHERE id = ?");
            $stmt2->bind_param("i", $user_id);
            $update_result = $stmt2->execute();
            $stmt2->close();

            if ($update_result === false) {
                // Handle update error
                $error_message = "Update failed: " . $stmt2->error;
                error_log($error_message);
                $this->database->rollback();
                Request::send_response(401, 'Failed to update user profile');
                return;
            }

            // Commit transaction
            $this->database->commit();
            Session::set('avator', $image_url);

            // Send success response
            $response = ['message' => 'Profile data saved successfully', 'status' => '200'];
            Request::send_response(200, $response);
        } else {

            $this->database->rollback();
            Request::send_response(401, 'Failed to insert user profile');
        }

        $stmt->close();
    }

    public function update_profile()
    {
        $request = Request::capture();

        $fullname = $request->input('fullName');
        $nin = $request->input('nin');
        $country = $request->input('country');
        $district = $request->input('district');
        $village = $request->input('village');
        $phone = $request->input('phone');
        $dob = $request->input('dob');
        $gender = $request->input('gender');
        $about = $request->input('about');
        $company = $request->input('company');
        $job = $request->input('job');

        $user_id = Session::get('user_id');

        $profile_update_query = "UPDATE user_profile
                                SET name = ?, nin = ?, dob = ?, gender = ?, about = ?, company = ?, job = ?, country = ?, district = ?, village = ?, phone = ?
                                WHERE user_id = ?";

        $stmt2 = $this->database->prepare($profile_update_query);
        $stmt2->bind_param("sssssssssssi", $fullname, $nin, $dob, $gender, $about, $company, $job, $country, $district, $village, $phone,  $user_id);
        $stmt2->execute();


        $response = ['message' => 'Profile data updated successfully', 'status' => '200'];
        $httpStatus = 200;
        Request::send_response($httpStatus, $response);
    }


    public function update_photo()
    {
        $request = Request::capture();
        $image_url = $request->input("image_url");

        $query = "UPDATE user_profile SET image_url = ? WHERE user_id = ?";
        $current_user = Session::get('user_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("si", $image_url, $current_user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            Session::set('avator', $image_url);
            $response = ['message' => 'Profile Photo Updated Successfully'];
            $httpStatus = 200;
        } else {
            $response = ['message' => 'Profile Photo Update failed']; //TODO chage alert error class
            $httpStatus = 401;
        }

        Request::send_response($httpStatus, $response);
    }


    public function change_password()
    {
        $request = Request::capture();
        $password = $request->input("newpassword");

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $current_user_id = Session::get('user_id');

            $query = "UPDATE app_users SET password = ? WHERE id = ?";

            $stmt = $this->database->prepare($query);
            $stmt->bind_param("si", $hashed_password, $current_user_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                Session::destroy();

                $response = ['message' => 'Password Updated Successfully'];
                $httpStatus = 200;
                Request::send_response($httpStatus, $response);
            } else {
                $response = ['message' => 'An Error Occured, Failed to Change Password!'];
                $httpStatus = 401;
                Request::send_response($httpStatus, $response);
            }
        }
    }

    public function check_identifier($identifier)
    {
        $query = "SELECT * FROM app_users WHERE email = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('s', $identifier);
        $stmt->execute();

        $result = $stmt->get_result();
       

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();


            // Set session data and sleep for 3 seconds
            Session::set('email_to_confirm', $user['email']);
            Session::set('user_id', $user['id']);
            sleep(3);

            $user_id = Session::get('user_id');
            $otp = $this->generateOTP();

            $result = $this->save_confirm_email_row($user_id, $otp);

            if ($result == 200) {
                $mail = new MailController();
                $result2 = $mail->send_confirm_email($otp, $user['email']);

                if ($result2['code'] == '200') {
                    $response = [
                        'exists' => true,
                        'emailConfirmed' => $user['email_confirmed'], // Assuming 'email_confirmed' means email confirmed
                        'message' => 'Account with provided identifier exists.'
                    ];
                    $httpStatus = 200;
                    Request::send_response($httpStatus, $response);
                }
            }
        } else {
            $response = [
                'exists' => false,
                'emailConfirmed' => false,
                'message' => 'Account with provided identifier does not exist.'
            ];
            $httpStatus = 401;
            sleep(3);
            Request::send_response($httpStatus, $response);
        }

        
    }

    public function generateOTP($length = 6)
    {
        return strtoupper(substr(md5(time() . mt_rand()), 0, $length));
    }

    public function save_confirm_email_row($user_id, $otp)
    {
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $this->database->prepare("INSERT INTO confirm_email_codes (user_id, otp, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param('iss', $user_id, $otp, $expires_at);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = 200;

            return $response;
        } else {
            $response = 500;
            return $response;
        }

        $stmt->close();
    }

    public function confirm_otp()
    {
        $request = Request::capture();

        $user_id = Session::get('user_id');
        $otp = $request->input('otp');

        // Begin a transaction
        $this->database->begin_transaction();

        $select_query = "SELECT user_id, otp FROM confirm_email_codes WHERE otp = ? AND user_id = ?";
        $update_query = "UPDATE app_users SET email_confirmed = ? WHERE id = ?";
        $delete_query = "DELETE FROM confirm_email_codes WHERE user_id = ?";

        $stmt = $this->database->prepare($select_query);
        $stmt->bind_param("ss", $otp, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Execute the UPDATE query
            $stmt = $this->database->prepare($update_query);
            $email_confirmed = 1;
            $stmt->bind_param("ii", $email_confirmed, $user_id);
            $stmt->execute();

            $stmt = $this->database->prepare($delete_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();


            $this->database->commit();

            $response = ['message' => 'Email Confirmed Successfully', 'status' => 200];
            $httpStatus = 200;
        } else {
            $this->database->rollback();

            $response = ['message' => 'Invalid OTP'];
            $httpStatus = 401;
        }

        Request::send_response($httpStatus, $response);
    }

    public function confirm_password_otp()
    {
        $request = Request::capture();

        $user_id = Session::get('user_id');
        $otp = $request->input('otp');

        // Begin a transaction
        $this->database->begin_transaction();

        $select_query = "SELECT user_id, otp FROM confirm_email_codes WHERE otp = ? AND user_id = ?";
        $delete_query = "DELETE FROM confirm_email_codes WHERE user_id = ?";

        $stmt = $this->database->prepare($select_query);
        $stmt->bind_param("ss", $otp, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $stmt = $this->database->prepare($delete_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();


            $this->database->commit();

            $response = ['message' => 'OTP Confirmed Successfully', 'status' => 200];
            $httpStatus = 200;
        } else {
            $this->database->rollback();

            $response = ['message' => 'Invalid OTP'];
            $httpStatus = 401;
        }

        Request::send_response($httpStatus, $response);
    }

    public function reset_password()
    {
        $request = Request::capture();
        $user_id = Session::get('user_id');
        $new_password = $request->input('newPassword');
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $this->database->prepare("UPDATE app_users SET password = ? WHERE id = ?");
        $stmt->bind_param('si', $hashed_password, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            Session::destroy();

            $response = ['message' => 'Password Updated Successfully', 'status' => 200];
            $httpStatus = 200;
            Request::send_response($httpStatus, $response);
        } else {
            $response = ['message' => 'An Error Occured, Failed to Change Password!'];
            $httpStatus = 401;
            Request::send_response($httpStatus, $response);
        }

        $stmt->close();
    }
}
