<?php

namespace controller;

use model\Model;

class OrganisationController
{
    private $model;

    public function __construct()
    {
        $this->model = Model::getInstance();
    }

    public function create_organisation()
    {
        $this->model->create_organisation();
    }

    public function update_organisation()
    {
        $this->model->update_organisation();
    }

    
}
