<?php

namespace core\exceptions;

use Exception;
use view\BladeView;

class PageProhibitedException extends Exception {

    private $blade_view;
    private $app_name;
    private $app_base_url;

    public function __construct()
    {
        $this->blade_view = new BladeView();
        $this->app_name = getenv("APP_NAME");
        $this->app_base_url = getenv("APP_BASE_URL");
    }

    public function render_403()
    {
        $html = $this->blade_view->render("403", [
            'pageTitle' => " $this->app_name - your not allowed to access this resource",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,

        ]);

        echo $html;
    }

}