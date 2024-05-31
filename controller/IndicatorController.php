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
}
