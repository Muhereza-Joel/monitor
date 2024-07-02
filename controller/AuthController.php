<?php

namespace controller;

use core\Request;
use Illuminate\Support\Facades\URL;
use core\Session;
use core\Uploader;
use model\Model;
use model\User;
use view\BladeView;

class AuthController
{

    private $app_name;
    private $app_name_full;
    private $app_base_url;
    private $user_model;
    private $model;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_base_url = getenv("APP_BASE_URL");
        $this->user_model = User::getInstance();
        $this->model = Model::getInstance();
    }

    public function index()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/login', [
            'pageTitle' => "$this->app_name Auth-Login",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'baseUrl' => $this->app_base_url,
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_register_view()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/register', [
            'pageTitle' => "$this->app_name Auth-Register",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'baseUrl' => $this->app_base_url,
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_start_reset()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/beginReset', [
            'pageTitle' => "$this->app_name reset account password",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'baseUrl' => $this->app_base_url,
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_reset_password()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/resetPassword', [
            'pageTitle' => "$this->app_name reset account password",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'baseUrl' => $this->app_base_url,
            'email' => Session::get('email_to_confirm'),
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_reset_password_step_one()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/stepOneResetPassword', [
            'pageTitle' => "$this->app_name reset account password",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'baseUrl' => $this->app_base_url,
            'email' => Session::get('email_to_confirm'),
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_confirm_email()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/confirmEmail', [
            'pageTitle' => "$this->app_name confirm email",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'baseUrl' => $this->app_base_url,
            'email' => Session::get('email_to_confirm'),
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_create_profile_view()
    {
        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/createProfile', [
            'pageTitle' => "$this->app_name Auth-Register",
            'appName' => $this->app_name,
            'username' => Session::get('username'),
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function render_show_profile_view()
    {

        $userDetails = $this->user_model->get_all_user_data(Session::get('user_id'));

        $blade_view = new BladeView();

        $myOrganisation = $this->user_model->get_user_organisation(Session::get('user_id'));
        $html = $blade_view->render('/auth/viewProfile', [
            'pageTitle' => "$this->app_name - Dashboard",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'userDetails' => $userDetails,
            'myOrganisation' => $myOrganisation['response'],
            'chosenOrganisationLogo' => Session::get('selected_organisation_logo'),
            'chosenOrganisationId' => Session::get('selected_organisation_id')
        ]);

        echo ($html);
    }

    public function sign_in_user()
    {

        $this->user_model->login();
    }

    public function sign_out()
    {
        Session::destroy();
        header("location:/$this->app_name/auth/challenge/login/");
    }

    public function set_choosen_organisation()
    {
        $request = Request::capture();
        $organisation_id = $request->input('organisation_id');
        Session::set('selected_organisation_id', $organisation_id);

        $logo = $this->model->get_selected_organisation_logo($organisation_id);
        Session::set('selected_organisation_logo', $logo);

        // Sleep for 1 second
        sleep(1);

        if ($organisation_id > 0) {
            $response = ['message' => 'Organisation Set Successfully'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['error' => 'Failed to set organisation'];
            $httpStatus = 500;

            Request::send_response($httpStatus, $response);
        }
    }


    public function create_account()
    {

        $this->user_model->add_user();
    }

    public function create_organisation_account()
    {
        $this->user_model->add_organisation_user();
    }

    public function create_viewer_account()
    {
        $this->user_model->add_viewer();
    }

    public function upload_photo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $uploader = new Uploader('image');
            $uploader->save_in("../$this->app_name/uploads/images/");

            if ($uploader->save()) {
                // Return the URL of the uploaded image
                echo $uploader->get_file_name();
            } else {
                http_response_code(500);
                echo 'Error uploading image.';
            }
        }
    }

    public function check_nin()
    {

        $this->user_model->check_nin();
    }
    public function check_email()
    {

        $this->user_model->check_email();
    }

    public function save_profile()
    {

        $this->user_model->save_profile();
    }

    public function update_profile()
    {

        $this->user_model->update_profile();
    }

    public function update_photo()
    {

        $this->user_model->update_photo();
    }

    public function check_password($password)
    {

        $this->user_model->check_password($password);
    }

    public function change_password()
    {

        $this->user_model->change_password();
    }

    public function get_user_details()
    {

        $userDetails = $this->user_model->get_all_user_data(Session::get('user_id'));
        Request::send_response(200, $userDetails);
    }

    public function check_identifier()
    {

        $request = Request::capture();
        $identifier = $request->input('identifier');
        $this->user_model->check_identifier($identifier);
    }

    public function confirm_otp()
    {
        $this->user_model->confirm_otp();
    }

    public function confirm_password_otp()
    {
        $this->user_model->confirm_password_otp();
    }

    public function reset_password()
    {
        $this->user_model->reset_password();
    }
}
