<?php

namespace middleware;

use core\exceptions\PageProhibitedException;
use core\Session;

class AdministratorPageMiddleware extends MiddlewareHandler
{
    public function handle()
    {
        try {
            $my_organisation_name = Session::get("my_organization_name");

            if ($my_organisation_name === null || $my_organisation_name !== "Administrator") {
                throw new PageProhibitedException();
            }
            return true;
        } catch (PageProhibitedException $e) {
            $e->render_404();
            return false;
        }
    }
}
