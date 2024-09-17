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
    const INDICATORS_TABLE = 'indicators';
    const RESPONSES_TABLE = 'responses';
    const USERS_TABLE = 'app_users';
    const COPY_TO_DELETED_RESPONSES_ARCHIVES_TABLE = 'responses_deleted_archive';
    const COPY_TO_DELETED_INDICATORS_ARCHIVES_TABLE = 'indicators_deleted_archive';
}