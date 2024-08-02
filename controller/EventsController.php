<?php

namespace controller;

use core\Request;
use model\Model;

class EventsController
{
    private $app_name;
    private $app_name_full;
    private $app_base_url;
    private $model;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_base_url = getenv("APP_BASE_URL");
        $this->model = Model::getInstance();
    }

    public function create_event()
    {
        $this->model->create_event();
    }

    public function get_events($visibilty = null)
    {
        Request::send_response(200, $this->model->get_events($visibilty, $active = 1));
    }

    public function get_my_organisation_events($visibilty)
    {
        Request::send_response(200, $this->model->get_my_organisation_events($visibilty));
    }

    public function delete_event($id)
    {
        $this->model->delete_event($id);
    }

    public function update_event()
    {
        $this->model->update_event();
    }
}
