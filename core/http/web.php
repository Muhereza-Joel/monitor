<?php

use core\Route;

Route::group([
    'middleware' => "AuthMiddleware",
    'prefix' => env("APP_NAME")
], function () {

    // Routes for the auth controller
    Route::get("/", "AuthController@index");
    Route::get("auth/register/", "AuthController@render_register_view");
    Route::get("auth/login/", "AuthController@index")->name('login');
    Route::get("auth/create-profile/", "AuthController@render_create_profile_view");
    Route::post("auth/login/sign-in/", "AuthController@sign_in_user");
    Route::post("auth/create-account/", "AuthController@create_account");
    Route::post("auth/organisation/create-account/", "AuthController@create_organisation_account");
    Route::post("auth/viewer/create-account/", "AuthController@create_viewer_account");
    Route::post("auth/check-nin/", "AuthController@check_nin");
    Route::post("auth/check-email/", "AuthController@check_email");
    Route::get("auth/check-password/", "AuthController@check_password");
    Route::post("auth/change-password/", "AuthController@change_password");
    Route::post("auth/save-profile/", "AuthController@save_profile");
    Route::post("auth/update-profile/", "AuthController@update_profile");
    Route::post("auth/user/profile/update-photo/", "AuthController@update_photo");
    Route::get("auth/sign-out/", "AuthController@sign_out");
    Route::get("auth/user/profile/", "AuthController@render_show_profile_view");
    Route::get("auth/users/", "AuthController@get_system_users");
    Route::get("auth/users/get-user-details/", "AuthController@get_user_details");
    Route::post("auth/accounts/check-identifier/", "AuthController@check_identifier");
    Route::get("auth/accounts/reset/", "AuthController@render_start_reset")->name('auth.accounts.reset');
    Route::get("auth/accounts/reset/step-one/", "AuthController@render_reset_password_step_one");
    Route::get("auth/accounts/reset/step-two/", "AuthController@render_confirm_email");
    Route::get("auth/accounts/reset/step-three/", "AuthController@render_reset_password");
    Route::post("auth/accounts/confirm-otp/", "AuthController@confirm_otp");
    Route::post("auth/accounts/confirm-password-otp/", "AuthController@confirm_password_otp");
    Route::post("auth/accounts/reset-password/", "AuthController@reset_password");
    Route::post("auth/set-organisation/", "AuthController@set_choosen_organisation");
    Route::post("auth/accounts/request-otp/", "MailController@request_otp");
    Route::post("image-upload/", "AuthController@upload_photo");
    Route::post("file-upload/", "AuthController@upload_file");
    Route::post("file-remove/", "AuthController@remove_file");
    Route::get("response/files/", "AuthController@get_files");
    Route::get("archived/response/files/", "AuthController@get_archived_response_files");

    //Routes for PageController
    Route::get("page-not-found/", "PageController@render_404");
    Route::get("dashboard/", "PageController@render_dashboard");
    Route::get("dashboard/users/", "PageController@render_users");
    Route::get("dashboard/users/add-new/", "PageController@render_create_user")->middleware(["RoleMiddleware:Administrator"]);
    Route::get("dashboard/users/view/{id}", "PageController@render_user_details")->name('user.details');
    Route::get("dashboard/manage-indicators/", "PageController@render_manage_indicator")->middleware(["RoleMiddleware:Administrator,User"]);
    Route::get("dashboard/indicators/", "PageController@render_view_indicators");
    Route::get("dashboard/indicators/archived/", "PageController@render_archived_indicators");
    Route::get("dashboard/all-archived-responses/", "PageController@render_archived_responses");
    Route::get("dashboard/indicators/edit/{id}", "PageController@render_edit_indicator")->middleware(["RoleMiddleware:Administrator,User"]);
    Route::get("dashboard/indicators/responses/edit/{id}", "PageController@render_edit_response")->middleware(["RoleMiddleware:Administrator,User"]);
    Route::get("dashboard/indicators/responses/add/{id}", "PageController@render_add_response")->middleware(["RoleMiddleware:Administrator,User"]);
    Route::get("dashboard/indicators/responses/all/{id}", "PageController@render_indicator_responses");
    Route::get("dashboard/indicators/archived/responses/all/{id}", "PageController@render_archived_indicator_responses");
    Route::get("dashboard/manage-indicators/resposes/", "PageController@render_responses");
    Route::get("dashboard/manage-indicators/u/resposes/", "PageController@render_user_responses");
    Route::get("dashboard/organizations/create/", "PageController@render_create_organization")->middleware(["AdministratorPageMiddleware"]);
    Route::get("dashboard/organizations/edit/{id}", "PageController@render_update_organization")->name('organization.edit')->middleware(["AdministratorPageMiddleware"]);
    Route::get("dashboard/organizations/users/create/", "PageController@render_create_organization_user")->middleware(["AdministratorPageMiddleware"]);
    Route::get("auth/organizations/choose/", "PageController@render_choose_organisation");
    Route::get("dashboard/organizations/choose/", "PageController@render_dashboard_choose_organisation");
    Route::get("dashboard/manage-events/", "PageController@render_manage_events")->middleware(["RoleMiddleware:Administrator"]);
    Route::get("database/connection/error/", "ErrorPageController@render_database_connection_error");
    Route::get("dashboard/reports/create-report/{id}", "PageController@render_create_report")->middleware(["RoleMiddleware:Administrator,User"]);


    //Routes for indicator controller
    Route::post("dashboard/manage-indicators/create/", "IndicatorController@create_indicator");
    Route::post("dashboard/manage-indicators/update/", "IndicatorController@update_indicator");
    Route::post("dashboard/manage-indicators/delete/{id}", "IndicatorController@delete_indicator");
    Route::post("dashboard/manage-indicators/resposes/create/", "IndicatorController@create_response");
    Route::post("dashboard/manage-indicators/resposes/response/edit/", "IndicatorController@edit_response");
    Route::post("dashboard/manage-indicators/responses/delete/{id}", "IndicatorController@delete_response");
    Route::post("dashboard/users/update-role", "IndicatorController@update_user_role");
    Route::post("dashboard/indicators/status/update", "IndicatorController@update_indicator_status");
    Route::post("dashboard/indicators/move-to-archives/", "IndicatorController@archive_indicators");
    Route::post("dashboard/indicators/responses/files/download", "IndicatorController@download_file");

    //Routes for mail controller

    //Routes for organisations controller
    Route::post("organisations/create/", "OrganisationController@create_organisation");
    Route::post("organisations/update/", "OrganisationController@update_organisation");

    //Routes for events controller
    Route::post("events/create/", "EventsController@create_event");
    Route::post("events/update/", "EventsController@update_event");
    Route::post("events/delete/{id}", "EventsController@delete_event");
    Route::get("events/get-events/", "EventsController@get_events");
    Route::get("events/get-my-organisation-events/", "EventsController@get_my_organisation_events");

    //Routes for reports controller 
    Route::post("reports/pdf/export/single/", "ReportsController@export_single_pdf_report");
    Route::post("reports/pdf/export/multiple/", "ReportsController@export_multiple_pdf_report");
    Route::post("reports/word/export/single/", "ReportsController@export_single_word_report");
    Route::post("reports/word/export/multiple/", "ReportsController@export_multiple_word_report");

    Route::get("lang/en", function () {
        dd('Closure reached!');
    })->name('lang.switch');
});
