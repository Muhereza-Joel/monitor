<?php
namespace middleware;

use core\Session;

class AuthMiddleware{
    private $app_name;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
    }
    public function handle(){
        $allowedRoutes = ["/$this->app_name/auth/register/", "/$this->app_name/auth/login/", "/$this->app_name/auth/login/sign-in/", "/$this->app_name/auth/create-account/"];

        $currentRoute = $_SERVER['REQUEST_URI'];
        if (in_array($currentRoute, $allowedRoutes)) {
            return true; 

        } else{
            return Session::isLoggedIn();
        }

    }
}
?>