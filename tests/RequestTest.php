<?php
namespace tests;


use core\Request;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php'; // Adjust the path as necessary
require_once __DIR__ . '/../autoload.php'; // Adjust the path as necessary

class RequestTest extends TestCase{
    public function testInput()
    {
        $_REQUEST['name'] = 'John';
        $_REQUEST['age'] = 25;

        $request = Request::capture();

        $this->assertEquals('John', $request->input('name'));
        $this->assertEquals(25, $request->input('age'));
        $this->assertEquals(null, $request->input('email'));
        // $this->assertEquals('default', $request->input('gender', 'default'));
    }

    public function testSendResponse()
    {
        $response = ['message' => 'Success'];
        ob_start();
        Request::send_response(200, $response);
    
        $this->expectOutputString(json_encode($response));
        $this->assertEquals(200, http_response_code());
    }

    public function testSendPdfResponse()
    {
        $pdfData = 'base64_encoded_pdf_data';

        ob_start();
        Request::send_pdf_response(200, $pdfData);
        $output = ob_get_clean();

        $this->expectOutputString(base64_encode($pdfData));
        $this->assertEquals(200, http_response_code());
        $this->assertEquals('application/pdf', $_SERVER['CONTENT_TYPE']);
    }
}