<?php

namespace core\exceptions;

use Exception;
use view\BladeView;

class RouteNotFoundException extends Exception
{

    private $blade_view;
    private $app_name;
    private $app_base_url;

    public function __construct()
    {
        $this->blade_view = new BladeView();
        $this->app_name = getenv("APP_NAME");
        $this->app_base_url = getenv("APP_BASE_URL");
    }

    public function render_404()
    {
        $html = $this->blade_view->render("404", [
            'pageTitle' => " $this->app_name - page not found",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,

        ]);
        echo $html;
    }
}