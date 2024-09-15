<?php

namespace middleware;

use core\exceptions\PageProhibitedException;
use core\Session;

class RoleMiddleware extends MiddlewareHandler
{
    protected $params = [];

    public function __construct(...$params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        try {
            $userRole = Session::get('role');

            // Flatten the params array before checking
            $flatAllowedRoles = is_array($this->params[0]) ? array_merge(...$this->params) : $this->params;

            if (!in_array($userRole, $flatAllowedRoles)) {
                throw new PageProhibitedException();
            }

            return true; // Role is allowed, proceed
        } catch (PageProhibitedException $e) {
            $e->render_403();
            return false;
        }
    }
}
