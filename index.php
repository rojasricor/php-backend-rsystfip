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
$map->post('save-person', '/api/person', __APP__ . 'save_person.php');
$map->post('save-user', '/api/user', __APP__ . 'save_user.php');

$map->put('update-person', '/api/person', __APP__ . 'update_person.php');
$map->put('update-password', '/api/password', __APP__ . 'update_password.php');

$map->patch('cancell-person', '/api/person', __APP__ . 'cancell_person.php');

$map->delete('delete-user', '/api/user', __APP__ . 'delete_user.php');

$map->get('get-resource', '/api/resource', __APP__ . 'get_resource.php');
$map->get('get-users', '/api/users', __APP__ . 'get_users.php');
$map->get('get-user', '/api/user', __APP__ . 'get_user.php');
$map->get('get-person', '/api/person', __APP__ . 'get_person.php');
$map->get('get-people', '/api/people', __APP__ . 'get_people.php');
$map->get('get-scheduling', '/api/scheduling', __APP__ . 'get_scheduling.php');
$map->get('get-deans', '/api/deans', __APP__ . 'get_deans.php');
$map->get('get-reports', '/api/reports', __APP__ . 'get_reports.php');
$map->get('get-reports-count', '/api/reports/count', __APP__ . 'get_reports_count.php');
$map->get('get-reports-counts', '/api/reports/counts', __APP__ . 'get_reports_counts.php');
$map->get('get-statistics-daily', '/api/statistics/daily', __APP__ . 'get_statistics_daily.php');
$map->get('get-statistics-daily-inrange', '/api/statistics/daily/inrange', __APP__ . 'get_mostagendated_daily_inrange.php');
$map->get('get-statistics-daily-alltime', '/api/statistics/daily/alltime', __APP__ . 'get_mostagendated_daily_alltime.php');
$map->get('get-statistics-scheduled', '/api/statistics/scheduled', __APP__ . 'get_statistics_scheduled.php');
$map->get('get-statistics-scheduled-inrange', '/api/statistics/scheduled/inrange', __APP__ . 'get_mostagendated_scheduled_inrange.php');
$map->get('get-statistics-scheduled-alltime', '/api/statistics/scheduled/alltime', __APP__ . 'get_mostagendated_scheduled_alltime.php');

$matcher = $router->getMatcher();
$route   = $matcher->match($request);

!$route ? $file = __APP__ . '404.php' : $file = $route->handler;
require $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
