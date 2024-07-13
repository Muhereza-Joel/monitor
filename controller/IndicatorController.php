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

    public function download_file($file)
    {
        if ($file) {
            // Define the full file path
            $filePath = realpath('uploads/files/' . $file);  // Use the realpath function to get the absolute path

            // Check if the file exists and is within the intended directory
            if ($filePath && strpos($filePath, realpath('uploads/files/')) === 0 && file_exists($filePath)) {
                // Clear output buffer
                if (ob_get_level()) {
                    ob_end_clean();
                }

                // Set headers
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($filePath));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');


                // Read the file
                readfile($filePath);
                exit;
            } else {
                // Return 404 if file not found
                http_response_code(404);
                die('File not found');
            }
        } else {
            // Return 400 for bad request if file is 0
            http_response_code(400);
            die('Invalid file parameter');
        }
    }
}
