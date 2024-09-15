<?php

use core\Route;

Route::group([
    'middleware' => "AuthMiddleware",
    'prefix' => ''
], function () {

    $app_name = getenv("APP_NAME");

    // Routes for the auth controller
    Route::get("/$app_name/", "AuthController@index");
    Route::get("/$app_name/auth/register/", "AuthController@render_register_view");
    Route::get("/$app_name/auth/login/", "AuthController@index");
    Route::get("/$app_name/auth/create-profile/", "AuthController@render_create_profile_view");
    Route::post("/$app_name/auth/login/sign-in/", "AuthController@sign_in_user");
    Route::post("/$app_name/auth/create-account/", "AuthController@create_account");
    Route::post("/$app_name/auth/organisation/create-account/", "AuthController@create_organisation_account");
    Route::post("/$app_name/auth/viewer/create-account/", "AuthController@create_viewer_account");
    Route::post("/$app_name/auth/check-nin/", "AuthController@check_nin");
    Route::post("/$app_name/auth/check-email/", "AuthController@check_email");
    Route::get("/$app_name/auth/check-password/", "AuthController@check_password");
    Route::post("/$app_name/auth/change-password/", "AuthController@change_password");
    Route::post("/$app_name/auth/save-profile/", "AuthController@save_profile");
    Route::post("/$app_name/auth/update-profile/", "AuthController@update_profile");
    Route::post("/$app_name/auth/user/profile/update-photo/", "AuthController@update_photo");
    Route::get("/$app_name/auth/sign-out/", "AuthController@sign_out");
    Route::get("/$app_name/auth/user/profile/", "AuthController@render_show_profile_view");
    Route::get("/$app_name/auth/users/", "AuthController@get_system_users");
    Route::get("/$app_name/auth/users/get-user-details/", "AuthController@get_user_details");
    Route::post("/$app_name/auth/accounts/check-identifier/", "AuthController@check_identifier");
    Route::get("/$app_name/auth/accounts/reset/", "AuthController@render_start_reset");
    Route::get("/$app_name/auth/accounts/reset/step-one/", "AuthController@render_reset_password_step_one");
    Route::get("/$app_name/auth/accounts/reset/step-two/", "AuthController@render_confirm_email");
    Route::get("/$app_name/auth/accounts/reset/step-three/", "AuthController@render_reset_password");
    Route::post("/$app_name/auth/accounts/confirm-otp/", "AuthController@confirm_otp");
    Route::post("/$app_name/auth/accounts/confirm-password-otp/", "AuthController@confirm_password_otp");
    Route::post("/$app_name/auth/accounts/reset-password/", "AuthController@reset_password");
    Route::post("/$app_name/auth/set-organisation/", "AuthController@set_choosen_organisation");
    Route::post("/$app_name/auth/accounts/request-otp/", "MailController@request_otp");
    Route::post("/$app_name/image-upload/", "AuthController@upload_photo");
    Route::post("/$app_name/file-upload/", "AuthController@upload_file");
    Route::post("/$app_name/file-remove/", "AuthController@remove_file");
    Route::get("/$app_name/response/files/", "AuthController@get_files");
    Route::get("/$app_name/archived/response/files/", "AuthController@get_archived_response_files");

    //Routes for PageController
    Route::get("/$app_name/page-not-found/", "PageController@render_404");
    Route::get("/$app_name/dashboard/", "PageController@render_dashboard");
    Route::get("/$app_name/dashboard/users/", "PageController@render_users");
    Route::get("/$app_name/dashboard/users/add-new/", "PageController@render_create_user");
    Route::get("/$app_name/dashboard/users/view/{id}", "PageController@render_user_details");
    Route::get("/$app_name/dashboard/manage-indicators/", "PageController@render_manage_indicator");
    Route::get("/$app_name/dashboard/indicators/", "PageController@render_view_indicators");
    Route::get("/$app_name/dashboard/indicators/archived/", "PageController@render_archived_indicators");
    Route::get("/$app_name/dashboard/all-archived-responses/", "PageController@render_archived_responses");
    Route::get("/$app_name/dashboard/indicators/edit/{id}", "PageController@render_edit_indicator");
    Route::get("/$app_name/dashboard/indicators/responses/edit/{id}", "PageController@render_edit_response");
    Route::get("/$app_name/dashboard/indicators/responses/add/{id}", "PageController@render_add_response");
    Route::get("/$app_name/dashboard/indicators/responses/all/{id}", "PageController@render_indicator_responses");
    Route::get("/$app_name/dashboard/indicators/archived/responses/all/{id}", "PageController@render_archived_indicator_responses");
    Route::get("/$app_name/dashboard/manage-indicators/resposes/", "PageController@render_responses");
    Route::get("/$app_name/dashboard/manage-indicators/u/resposes/", "PageController@render_user_responses");
    Route::get("/$app_name/dashboard/organizations/create/", "PageController@render_create_organization")->middleware(["AdministratorPageMiddleware"]);
    Route::get("/$app_name/dashboard/organizations/edit/{id}", "PageController@render_update_organization");
    Route::get("/$app_name/dashboard/organizations/users/create/", "PageController@render_create_organization_user");
    Route::get("/$app_name/auth/organizations/choose/", "PageController@render_choose_organisation");
    Route::get("/$app_name/dashboard/organizations/choose/", "PageController@render_dashboard_choose_organisation");
    Route::get("/$app_name/dashboard/manage-events/", "PageController@render_manage_events");
    Route::get("/$app_name/database/connection/error/", "ErrorPageController@render_database_connection_error");
    Route::get("/$app_name/dashboard/reports/create-report/{id}", "PageController@render_create_report");


    //Routes for indicator controller
    Route::post("/$app_name/dashboard/manage-indicators/create/", "IndicatorController@create_indicator");
    Route::post("/$app_name/dashboard/manage-indicators/update/", "IndicatorController@update_indicator");
    Route::post("/$app_name/dashboard/manage-indicators/delete/{id}", "IndicatorController@delete_indicator");
    Route::post("/$app_name/dashboard/manage-indicators/resposes/create/", "IndicatorController@create_response");
    Route::post("/$app_name/dashboard/manage-indicators/resposes/response/edit/", "IndicatorController@edit_response");
    Route::post("/$app_name/dashboard/manage-indicators/responses/delete/{id}", "IndicatorController@delete_response");
    Route::post("/$app_name/dashboard/users/update-role", "IndicatorController@update_user_role");
    Route::post("/$app_name/dashboard/indicators/status/update", "IndicatorController@update_indicator_status");
    Route::post("/$app_name/dashboard/indicators/move-to-archives/", "IndicatorController@archive_indicators");
    Route::post("/$app_name/dashboard/indicators/responses/files/download", "IndicatorController@download_file");

    //Routes for mail controller

    //Routes for organisations controller
    Route::post("/$app_name/organisations/create/", "OrganisationController@create_organisation");
    Route::post("/$app_name/organisations/update/", "OrganisationController@update_organisation");

    //Routes for events controller
    Route::post("/$app_name/events/create/", "EventsController@create_event");
    Route::post("/$app_name/events/update/", "EventsController@update_event");
    Route::post("/$app_name/events/delete/{id}", "EventsController@delete_event");
    Route::get("/$app_name/events/get-events/", "EventsController@get_events");
    Route::get("/$app_name/events/get-my-organisation-events/", "EventsController@get_my_organisation_events");

    //Routes for reports controller 
    Route::post("/$app_name/reports/pdf/export/single/", "ReportsController@export_single_pdf_report");
    Route::post("/$app_name/reports/pdf/export/multiple/", "ReportsController@export_multiple_pdf_report");
    Route::post("/$app_name/reports/word/export/single/", "ReportsController@export_single_word_report");
    Route::post("/$app_name/reports/word/export/multiple/", "ReportsController@export_multiple_word_report");
    
});
