<?php

namespace controller;

use model\Model;

class IndicatorController
{
    private $model;

    public function __construct()
    {
        $this->model = Model::getInstance();
    }

    public function create_indicator()
    {
        $this->model->create_indicator();
    }

    public function update_indicator()
    {
        $this->model->update_indicator();
    }

    public function delete_indicator($id)
    {
        $this->model->delete_indicator($id);
    }

    public function create_response()
    {
        $this->model->create_response();
    }

    public function edit_response()
    {
        $this->model->edit_response();
    }

    public function delete_response($id)
    {
        $this->model->delete_response($id);
    }

    public function update_user_role()
    {
        $this->model->update_user_role();
    }

    public function update_indicator_status($id, $status)
    {
        $this->model->update_indicator_status($id, $status);
    }

    public function archive_indicators()
    {
        $this->model->archive_indicators();
    }
}
