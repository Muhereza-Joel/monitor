<?php

namespace controller;

use core\Session;
use model\Model;
use model\User;
use view\BladeView;

class PageController
{
    private $app_name;
    private $app_name_full;
    private $app_base_url;
    private $blade_view;
    private $model;
    private $userModel;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_base_url = getenv("APP_BASE_URL");
        $this->blade_view = new BladeView();
        $this->model =  Model::getInstance();
        $this->userModel = User::getInstance();
    }

    public function render_404()
    {
        $html = $this->blade_view->render('404', [
            'pageTitle' => " $this->app_name - page not found",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),

        ]);

        echo ($html);
    }

    public function render_dashboard()
    {
        $indicators_count = $this->model->get_indicators_count();
        $responses_count = $this->model->get_responses_count();
        $user_responses_count = $this->model->get_user_responses_count();
        $users_count = $this->model->get_users_count();
        $organisations = $this->model->get_organisations();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('dashboard', [
            'pageTitle' => " $this->app_name - dashboard",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'organisations' => $organisations['response'],
            'myOrganisation' => $myOrganisation['response'],
            'indicatorsCount' => $indicators_count,
            'responsesCount' => $responses_count,
            'userResponsesCount' => $user_responses_count,
            'usersCount' => $users_count,

        ]);

        echo ($html);
    }

    public function render_manage_indicator()
    {
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('manageIndicator', [
            'pageTitle' => " $this->app_name - manage indicators",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'myOrganisation' => $myOrganisation['response'],
        ]);

        echo ($html);
    }

    public function render_edit_indicator($id)
    {
        $result = $this->model->get_indicator($id);
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('editIndicator', [
            'pageTitle' => " $this->app_name - edit indicator",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'indicator' => $result['response'],
            'myOrganisation' => $myOrganisation['response'],
        ]);

        echo ($html);
    }

    public function render_edit_response($id)
    {
        $result = $this->model->get_response($id);
        $row = $result['response'];
        $indicator_id = $row['indicator_id'];
        $last_current_state = $this->model->get_last_response_current_state($indicator_id);
        $indicator = $this->model->get_indicator($indicator_id);
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('editResponse', [
            'pageTitle' => " $this->app_name - edit response",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'response' => $result['response'],
            'lastCurrentState' => $last_current_state['response'],
            'indicator' => $indicator['response'],
            'myOrganisation' => $myOrganisation['response'],

        ]);

        echo ($html);
    }

    public function render_view_indicators()
    {
        $indicators = $this->model->get_all_indicators();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('viewIndicators', [
            'pageTitle' => " $this->app_name - view indicators",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'indicators' => $indicators['response'],
            'myOrganisation' => $myOrganisation['response'],

        ]);

        echo ($html);
    }

    public function render_add_response($id)
    {
        $indicator = $this->model->get_indicator($id);
        $last_current_state = $this->model->get_last_response_current_state($id);
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('addResponse', [
            'pageTitle' => " $this->app_name - addResponse",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'indicatorId' => $id,
            'indicator' => $indicator['response'],
            'lastCurrentState' => $last_current_state['response'],
            'myOrganisation' => $myOrganisation['response'],

        ]);

        echo ($html);
    }

    public function render_responses()
    {
        $responses = $this->model->get_all_responses();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('responses', [
            'pageTitle' => " $this->app_name - all responses",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'responses' => $responses['response'],
            'myOrganisation' => $myOrganisation['response'],

        ]);

        echo ($html);
    }

    public function render_indicator_responses($id)
    {
        $responses = $this->model->get_indicator_responses($id);
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('responses', [
            'pageTitle' => " $this->app_name - all indicator responses",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'responses' => $responses['response'],
            'myOrganisation' => $myOrganisation['response'],

        ]);

        echo ($html);
    }

    public function render_user_responses()
    {
        $responses = $this->model->get_all_user_responses();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('responses', [
            'pageTitle' => " $this->app_name - my responses",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'responses' => $responses['response'],
            'myOrganisation' => $myOrganisation['response'],

        ]);

        echo ($html);
    }

    public function render_users()
    {
        $result = $this->model->get_all_users();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('users', [
            'pageTitle' => "$this->app_name - users",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'users' => $result['response'],
            'myOrganisation' => $myOrganisation['response'],
        ]);

        echo ($html);
    }

    public function render_user_details($id)
    {
        $result = $this->model->get_user_details($id);
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('viewUser', [
            'pageTitle' => "$this->app_name - user details",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'userDetails' => $result['response'],
            'myOrganisation' => $myOrganisation['response'],
        ]);

        echo ($html);
    }

    public function render_create_user()
    {
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('createUser', [
            'pageTitle' => "$this->app_name - create user",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'myOrganisation' => $myOrganisation['response'],
            
        ]);

        echo ($html);
    }

    public function render_create_organization()
    {
        $organisations = $this->model->get_organisations();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('createOrganisations', [
            'pageTitle' => "$this->app_name - create organisation",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'organisations' => $organisations['response'],
            'myOrganisation' => $myOrganisation['response'],
            
        ]);

        echo ($html);
    }

    public function render_choose_organisation()
    {
        $organisations = $this->model->get_organisations();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('chooseOrganisation', [
            'pageTitle' => "$this->app_name - Choose organisation",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'organisations' => $organisations['response'],
            'callbackUrl' => $_SERVER['HTTP_REFERER'],
            'myOrganisation' => $myOrganisation['response'],
            
        ]);

        echo ($html);
    }

    public function render_dashboard_choose_organisation()
    {
        $organisations = $this->model->get_organisations();
        $myOrganisation = $this->userModel->get_user_organisation(Session::get('user_id'));

        $html = $this->blade_view->render('chooseOrganisationTwo', [
            'pageTitle' => "$this->app_name - Choose organisation",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'organisations' => $organisations['response'],
            'callbackUrl' => $this->app_base_url . '/'. $this->app_name . '/auth/sign-out/',
            'myOrganisation' => $myOrganisation['response'],
            
        ]);

        echo ($html);
    }

} 
