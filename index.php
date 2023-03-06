<?php

require_once 'vendor/autoload.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
  $_FILES
);

$router = new Aura\Router\RouterContainer();

$map = $router->getMap();

$map->post('auth', '/api/auth', 'auth.php');
$map->post('save-reg', '/api/save/reg', 'reg_save.php');
$map->post('update-reg', '/api/update/reg', 'reg_update.php');
$map->post('save-user', '/api/save/user', 'save_user.php');
$map->post('update-password', '/api/update/password', 'update_password.php');

$map->get('get-resources', '/api/get/resources', 'get_resources.php');
$map->get('get-dashboard', '/api/get/users/manage', 'get_users_dashboard.php');
$map->get('get-one-user', '/api/get/users/one', 'get_user_by_id.php');
$map->get('get-one-person', '/api/get/person/one', 'get_person_by_id.php');
$map->get('get-people', '/api/get/people', 'get_people.php');
$map->get('get-events-calendar', '/api/get/events/scheduling', 'get_scheduled_scheduling.php');
$map->get('get-deans', '/api/get/staffdeans/itfip', 'get_staff_deans.php');
$map->get('cancell-scheduling', '/api/cancell/scheduling', 'cancell_scheduling.php');
$map->get('get-reports', '/api/get/reports', 'get_reports_by_date.php');
$map->get('get-report', '/api/RSystfip-report-' . RSystfip\TimeController::todayDate(), 'report.php');
$map->get('get-statistics', '/api/get/statistics', 'get_statistics_by_date.php');
$map->get('get-statistics-inrange', '/api/get/statistics/inrange', 'get_most_agendated_by_date.php');
$map->get('get-statistics-alltime', '/api/get/statistics/alltime', 'get_most_agendated_of_all_time.php');
$map->get('delete-user', '/api/delete/user', 'delete_user.php');

$matcher = $router->getMatcher();
$route   = $matcher->match($request);
$url     = $router->getGenerator();

!$route ? $file = '404.php' : $file = $route->handler;
require $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
