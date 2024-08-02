<?php

use core\Route;

$app_name = getenv("APP_NAME");

// Routes for the auth controller
Route::post("/$app_name/", "controller\AuthController@index");
Route::post("/$app_name/auth/register/", "controller\AuthController@render_register_view");
Route::post("/$app_name/auth/login/", "controller\AuthController@index");
Route::post("/$app_name/auth/create-profile/", "controller\AuthController@render_create_profile_view");
Route::post("/$app_name/auth/login/sign-in/", "controller\AuthController@sign_in_user");
Route::post("/$app_name/auth/create-account/", "controller\AuthController@create_account");
Route::post("/$app_name/auth/organisation/create-account/", "controller\AuthController@create_organisation_account");
Route::post("/$app_name/auth/viewer/create-account/", "controller\AuthController@create_viewer_account");
Route::post("/$app_name/image-upload/", "controller\AuthController@upload_photo");
Route::post("/$app_name/file-upload/", "controller\AuthController@upload_file");
Route::post("/$app_name/file-remove/", "controller\AuthController@remove_file");
Route::post("/$app_name/response/files/", "controller\AuthController@get_files");
Route::post("/$app_name/archived/response/files/", "controller\AuthController@get_archived_response_files");
Route::post("/$app_name/auth/check-nin/", "controller\AuthController@check_nin");
Route::post("/$app_name/auth/check-email/", "controller\AuthController@check_email");
Route::post("/$app_name/auth/check-password/", "controller\AuthController@check_password");
Route::post("/$app_name/auth/change-password/", "controller\AuthController@change_password");
Route::post("/$app_name/auth/save-profile/", "controller\AuthController@save_profile");
Route::post("/$app_name/auth/update-profile/", "controller\AuthController@update_profile");
Route::post("/$app_name/auth/user/profile/update-photo/", "controller\AuthController@update_photo");
Route::post("/$app_name/auth/sign-out/", "controller\AuthController@sign_out");
Route::post("/$app_name/auth/user/profile/", "controller\AuthController@render_show_profile_view");
Route::post("/$app_name/auth/users/", "controller\AuthController@get_system_users");
Route::post("/$app_name/auth/users/get-user-details/", "controller\AuthController@get_user_details");
Route::post("/$app_name/auth/accounts/check-identifier/", "controller\AuthController@check_identifier");
Route::post("/$app_name/auth/accounts/reset/", "controller\AuthController@render_start_reset");
Route::post("/$app_name/auth/accounts/reset/step-one/", "controller\AuthController@render_reset_password_step_one");
Route::post("/$app_name/auth/accounts/reset/step-two/", "controller\AuthController@render_confirm_email");
Route::post("/$app_name/auth/accounts/reset/step-three/", "controller\AuthController@render_reset_password");
Route::post("/$app_name/auth/accounts/confirm-otp/", "controller\AuthController@confirm_otp");
Route::post("/$app_name/auth/accounts/confirm-password-otp/", "controller\AuthController@confirm_password_otp");
Route::post("/$app_name/auth/accounts/reset-password/", "controller\AuthController@reset_password");
Route::post("/$app_name/auth/set-organisation/", "controller\AuthController@set_choosen_organisation");

//Routes for PageController
Route::post("/$app_name/page-not-found/", "controller\PageController@render_404");
Route::post("/$app_name/dashboard/", "controller\PageController@render_dashboard");
Route::post("/$app_name/dashboard/users/", "controller\PageController@render_users");
Route::post("/$app_name/dashboard/users/add-new/", "controller\PageController@render_create_user");
Route::post("/$app_name/dashboard/users/view", "controller\PageController@render_user_details");
Route::post("/$app_name/dashboard/manage-indicators/", "controller\PageController@render_manage_indicator");
Route::post("/$app_name/dashboard/indicators/", "controller\PageController@render_view_indicators");
Route::post("/$app_name/dashboard/indicators/archived/", "controller\PageController@render_archived_indicators");
Route::post("/$app_name/dashboard/all-archived-responses/", "controller\PageController@render_archived_responses");
Route::post("/$app_name/dashboard/indicators/edit", "controller\PageController@render_edit_indicator");
Route::post("/$app_name/dashboard/indicators/responses/edit", "controller\PageController@render_edit_response");
Route::post("/$app_name/dashboard/indicators/responses/add", "controller\PageController@render_add_response");
Route::post("/$app_name/dashboard/indicators/responses/all", "controller\PageController@render_indicator_responses");
Route::post("/$app_name/dashboard/indicators/archived/responses/all", "controller\PageController@render_archived_indicator_responses");
Route::post("/$app_name/dashboard/manage-indicators/resposes/", "controller\PageController@render_responses");
Route::post("/$app_name/dashboard/manage-indicators/u/resposes/", "controller\PageController@render_user_responses");
Route::post("/$app_name/dashboard/organizations/create/", "controller\PageController@render_create_organization");
Route::post("/$app_name/dashboard/organizations/update", "controller\PageController@render_update_organization");
Route::post("/$app_name/dashboard/organizations/users/create/", "controller\PageController@render_create_organization_user");
Route::post("/$app_name/auth/organizations/choose/", "controller\PageController@render_choose_organisation");
Route::post("/$app_name/dashboard/organizations/choose/", "controller\PageController@render_dashboard_choose_organisation");
Route::post("/$app_name/dashboard/manage-events/", "controller\PageController@render_manage_events");
Route::post("/$app_name/database/connection/error/", "controller\ErrorPageController@render_database_connection_error");



//Routes for indicator controller
Route::post("/$app_name/dashboard/manage-indicators/create/", "controller\IndicatorController@create_indicator");
Route::post("/$app_name/dashboard/manage-indicators/update/", "controller\IndicatorController@update_indicator");
Route::post("/$app_name/dashboard/manage-indicators/delete/", "controller\IndicatorController@delete_indicator");
Route::post("/$app_name/dashboard/manage-indicators/resposes/create/", "controller\IndicatorController@create_response");
Route::post("/$app_name/dashboard/manage-indicators/resposes/response/edit/", "controller\IndicatorController@edit_response");
Route::post("/$app_name/dashboard/manage-indicators/responses/delete", "controller\IndicatorController@delete_response");
Route::post("/$app_name/dashboard/users/update-role", "controller\IndicatorController@update_user_role");
Route::post("/$app_name/dashboard/indicators/status/update", "controller\IndicatorController@update_indicator_status");
Route::post("/$app_name/dashboard/indicators/move-to-archives/", "controller\IndicatorController@archive_indicators");
Route::post("/$app_name/dashboard/indicators/responses/files/download", "controller\IndicatorController@download_file");

//Routes for mail controller
Route::post("/$app_name/auth/accounts/request-otp/", "controller\MailController@request_otp");

//Routes for organisations controller
Route::post("/$app_name/organisations/create/", "controller\OrganisationController@create_organisation");
Route::post("/$app_name/organisations/update/", "controller\OrganisationController@update_organisation");

//Routes for events controller
Route::post("/$app_name/events/create/", "controller\EventsController@create_event");
Route::post("/$app_name/events/update/", "controller\EventsController@update_event");
Route::post("/$app_name/events/delete/", "controller\EventsController@delete_event");
Route::post("/$app_name/events/get-events/", "controller\EventsController@get_events");
Route::post("/$app_name/events/get-my-organisation-events/", "controller\EventsController@get_my_organisation_events");
