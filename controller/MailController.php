<?php

namespace controller;

use core\Request;
use core\Session;
use Exception;
use model\User;
use PHPMailer\PHPMailer\PHPMailer;
use view\BladeView;

class MailController
{
    private $blade_view;
    private $app_name;
    private $app_base_url;
    private $smtp_server;
    private $mail_agent;
    private $mail_key;
    private $mail_sender;
    private $mail_title;
    private $user_model;

    public function __construct()
    {
        $this->blade_view = new BladeView();
        $this->app_name = getenv("APP_NAME");
        $this->app_base_url = getenv("APP_BASE_URL");
        $this->smtp_server = getenv("SMTP_SERVER");
        $this->mail_agent = getenv("APP_MAIL_CLIENT");
        $this->mail_key = getenv("APP_MAIL_KEY");
        $this->mail_sender = getenv("APP_MAIL_SENDER");
        $this->mail_title = getenv("APP_MAIL_TITLE");
        $this->user_model = User::getInstance();
    }

    public function send_confirm_email($otp, $email)
    {
        $request = Request::capture();

        $to = $email;
        $subject = "ODA M $ E Monitor Email Confirmation";

        $html_body = $this->blade_view->render('confirmEmail', [
            'pageTitle' => " $this->app_name",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'otp' => $otp,
        ]);

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;                     
            $mail->isSMTP();                              
            $mail->Host = $this->smtp_server;          
            $mail->SMTPAuth = true;                    
            $mail->Username = $this->mail_agent;          
            $mail->Password = $this->mail_key;          
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            ); 

            // Recipients
            $mail->setFrom($this->mail_sender, $this->mail_title);
            $mail->addAddress($to);                    // Add a recipient

            // Content
            $mail->isHTML(true);                       // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $html_body;

            $mail->send();

            $response = ['status' => 'success', 'code' => '200', 'message' => 'Message has been sent'];
            return $response;
        } catch (Exception $e) {
            $response = ['status' => 'error', 'code' => '500', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
            return $response;
        }
    }

    public function request_otp()
    {
        $request = Request::capture();
        $otp = $this->user_model->generateOTP(6);
        $user_id = Session::get('user_id');
        $email = $request->input('email');


        $result = $this->user_model->save_confirm_email_row($user_id, $otp);

        if($result == 200){

            $to = $email;
            $subject = "ODA M $ E Monitor Email Confirmation";
    
            $html_body = $this->blade_view->render('requestOTP', [
                'pageTitle' => " $this->app_name",
                'appName' => $this->app_name,
                'baseUrl' => $this->app_base_url,
                'otp' => $otp,
            ]);
    
            $mail = new PHPMailer(true);
    
            try {
                // Server settings
                $mail->SMTPDebug = 0;                     
                $mail->isSMTP();                              
                $mail->Host = $this->smtp_server;          
                $mail->SMTPAuth = true;                    
                $mail->Username = $this->mail_agent;          
                $mail->Password = $this->mail_key;          
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port = 587;
    
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                ); 
    
                // Recipients
                $mail->setFrom($this->mail_sender, $this->mail_title);
                $mail->addAddress($to);                    // Add a recipient
    
                // Content
                $mail->isHTML(true);                       // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $html_body;
    
                $mail->send();
    
                $response = ['status' => 'success', 'status' => 200, 'message' => 'Message has been sent'];
                Request::send_response(200, $response);

            } catch (Exception $e) {
                $response = ['status' => 'error', 'status' => 500, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
                Request::send_response(500, $response);
            }
        }

    }
}
