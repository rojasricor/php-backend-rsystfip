<?php

require_once 'vendor/autoload.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
  $_FILES
);

define('__APP__', 'app/models/');

$router = new Aura\Router\RouterContainer();

$map = $router->getMap();

$map->post('auth', '/api/auth', __APP__ . 'auth.php');
$map->post('save-reg', '/api/save/reg', __APP__ . 'reg_save.php');
$map->post('update-reg', '/api/update/reg', __APP__ . 'reg_update.php');
$map->post('save-user', '/api/save/user', __APP__ . 'save_user.php');
$map->post('update-password', '/api/update/password', __APP__ . 'update_password.php');

$map->get('get-resources', '/api/get/resources', __APP__ . 'get_resources.php');
$map->get('get-dashboard', '/api/get/users/manage', __APP__ . 'get_users_dashboard.php');
$map->get('get-one-user', '/api/get/users/one', __APP__ . 'get_user_by_id.php');
$map->get('get-one-person', '/api/get/person/one', __APP__ . 'get_person_by_id.php');
$map->get('get-people', '/api/get/people', __APP__ . 'get_people.php');
$map->get('get-events-calendar', '/api/get/events/scheduling', __APP__ . 'get_scheduled_scheduling.php');
$map->get('get-deans', '/api/get/staffdeans/itfip', __APP__ . 'get_staff_deans.php');
$map->get('cancell-scheduling', '/api/cancell/scheduling', __APP__ . 'cancell_scheduling.php');
$map->get('get-reports', '/api/get/reports', __APP__ . 'get_reports_by_date.php');
$map->get('get-report', '/api/RSystfip-report-' . app\controllers\TimeController::todayDate(), __APP__ . 'report.php');
$map->get('get-statistics-daily', '/api/get/statistics/daily', __APP__ . 'get_statistics_st_daily_by_date.php');
$map->get('get-statistics-daily-inrange', '/api/get/statistics/daily/inrange', __APP__ . 'get_most_agendated_st_daily_by_date.php');
$map->get('get-statistics-daily-alltime', '/api/get/statistics/daily/alltime', __APP__ . 'get_most_agendated_st_daily_of_all_time.php');
$map->get('get-statistics-scheduled', '/api/get/statistics/scheduled', __APP__ . 'get_statistics_st_scheduled_by_date.php');
$map->get('get-statistics-scheduled-inrange', '/api/get/statistics/scheduled/inrange', __APP__ . 'get_most_agendated_st_scheduled_by_date.php');
$map->get('get-statistics-scheduled-alltime', '/api/get/statistics/scheduled/alltime', __APP__ . 'get_most_agendated_st_scheduled_of_all_time.php');
$map->get('delete-user', '/api/delete/user', __APP__ . 'delete_user.php');

$matcher = $router->getMatcher();
$route   = $matcher->match($request);
$url     = $router->getGenerator();

!$route ? $file = __APP__ . '404.php' : $file = $route->handler;
require $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
