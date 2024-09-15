<?php

namespace core\constants;

class ActionRegistry {
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    // Description templates
    const DESCRIPTION_LOGIN = 'User logged in from IP: ';
    const DESCRIPTION_LOGOUT = 'User logged out.';
    const DESCRIPTION_CREATE = 'Created record with ID: ';
    const DESCRIPTION_UPDATE = 'Updated record with ID: ';
    const DESCRIPTION_DELETE = 'Deleted record with ID: ';
    
    // You can add more constants or descriptions as needed
}