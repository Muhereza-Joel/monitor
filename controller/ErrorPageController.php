<?php

namespace controller;

use core\Session;
use model\Model;
use model\User;
use view\BladeView;

class ErrorPageController
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
    }


    public function render_database_connection_error()
    {

        $html = $this->blade_view->render('databaseConnectionError', [
            'pageTitle' => "$this->app_name - database connection error",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),


        ]);

        echo ($html);
    }
}
