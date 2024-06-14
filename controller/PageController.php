<?php

namespace controller;

use core\Session;
use model\Model;
use view\BladeView;

class PageController
{
    private $app_name;
    private $app_name_full;
    private $app_base_url;
    private $blade_view;
    private $model;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_base_url = getenv("APP_BASE_URL");
        $this->blade_view = new BladeView();
        $this->model =  Model::getInstance();
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
        $html = $this->blade_view->render('dashboard', [
            'pageTitle' => " $this->app_name - dashboard",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            

        ]);

        echo ($html);
    }

    public function render_manage_indicator()
    {
        $html = $this->blade_view->render('manageIndicator', [
            'pageTitle' => " $this->app_name - manage indicators",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            

        ]);

        echo ($html);
    }

    public function render_edit_indicator($id)
    {
        $result = $this->model->get_indicator($id);

        $html = $this->blade_view->render('editIndicator', [
            'pageTitle' => " $this->app_name - edit indicator",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'indicator' => $result['response']
            

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

        ]);

        echo ($html);
    }

    public function render_view_indicators()
    {
        $indicators = $this->model->get_all_indicators();

        $html = $this->blade_view->render('viewIndicators', [
            'pageTitle' => " $this->app_name - view indicators",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'indicators' => $indicators['response'],

        ]);

        echo ($html);
    }

    public function render_add_response($id)
    {
        $indicator = $this->model->get_indicator($id);
        $last_current_state = $this->model->get_last_response_current_state($id);

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

        ]);

        echo ($html);
    }

    public function render_responses()
    {
        $responses = $this->model->get_all_responses();

        $html = $this->blade_view->render('responses', [
            'pageTitle' => " $this->app_name - all responses",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'responses' => $responses['response']

        ]);

        echo ($html);
    }

    public function render_user_responses()
    {
        $responses = $this->model->get_all_user_responses();

        $html = $this->blade_view->render('responses', [
            'pageTitle' => " $this->app_name - my responses",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'responses' => $responses['response']

        ]);

        echo ($html);
    }

    public function render_users()
    {
        $result = $this->model->get_all_users();

        $html = $this->blade_view->render('users', [
            'pageTitle' => "$this->app_name - users",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'users' => $result['response'],
        ]);

        echo ($html);
    }

    public function render_user_details($id)
    {
        $result = $this->model->get_user_details($id);

        $html = $this->blade_view->render('viewUser', [
            'pageTitle' => "$this->app_name - user details",
            'appName' => $this->app_name,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'userDetails' => $result['response'],
        ]);

        echo ($html);
    }

} 
