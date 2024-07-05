<?php

namespace core;

class Request
{

    public static function capture()
    {
        return new self();
    }

    /**
     * Get the value of the specified input key.
     *
     * @param string $key The input key.
     * @param mixed $default The default value if the key is not found.
     * @return mixed The value of the input key or the default value.
     */
    public function input($key, $default = null)
    {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }



    /**
     * Send a JSON response with the specified HTTP status code.
     *
     * @param int $http_status The HTTP status code.
     * @param mixed $response The response data.
     * @return void
     */
    public static function send_response($http_status, $response)
    {
        header('Content-Type: application/json');
        http_response_code($http_status);
        echo json_encode($response);
    }
    
    /**
     * Send a PDF response with the specified HTTP status code.
     *
     * @param int $http_status The HTTP status code.
     * @param string $response The base64 encoded PDF data.
     * @return void
     */
    public static function send_pdf_response($http_status, $response)
    {
        http_response_code($http_status);
        header('Content-Type: application/pdf');
        echo base64_encode($response);
    }
    
}
