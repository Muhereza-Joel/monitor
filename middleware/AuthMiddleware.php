<?php

namespace middleware;

use core\Session;
use middleware\MiddlewareHandler as MiddlewareMiddlewareHandler;

class AuthMiddleware extends MiddlewareMiddlewareHandler
{
    private $app_name;
    private $app_base_url;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_base_url = getenv("APP_BASE_URL");
    }
    public function handle()
    {
        $allowedRoutes = [
            "/$this->app_name/auth/register/", 
            "/$this->app_name/database/connection/error/", 
            "/$this->app_name/database/error_page/", 
            "/$this->app_name/auth/login/", 
            "/$this->app_name/auth/login/sign-in/", 
            "/$this->app_name/auth/create-account/", 
            "/$this->app_name/auth/viewer/create-account/", 
            "/$this->app_name/auth/accounts/reset/", 
            "/$this->app_name/auth/accounts/check-identifier/",
            "/$this->app_name/auth/accounts/confirm-otp/",
            "/$this->app_name/auth/accounts/reset/step-one/",
            "/$this->app_name/auth/accounts/reset/step-two/",
            "/$this->app_name/auth/accounts/reset/step-three/",
            "/$this->app_name/auth/accounts/request-otp/",
            "/$this->app_name/auth/organizations/choose/",
            "/$this->app_name/auth/set-organisation/",
        ];

        $currentRoute = $_SERVER['REQUEST_URI'];
        if (in_array($currentRoute, $allowedRoutes)) {
            return true;
        } else {
            if(Session::isLoggedIn()){
                return true;
            } else{
                header("Location: {$this->app_base_url}/auth/login/");
            };
        }
    }
}
