<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;
use App\Middlewares\CorsMiddleware;

// Create an instance of route container
$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

// Routes
$map->post('auth', '/api/auth', [
  'App\Controllers\AuthController',
  'auth'
]);

$map->post('auth.recover.password', '/api/auth/recover/password', [
  'App\Controllers\AuthController',
  'recoverPassword'
]);

$map->post('verify.resetToken', '/api/auth/verify/resetToken', [
  'App\Controllers\AuthController',
  'verifyResetToken'
]);

$map->delete('delete.resetToken', '/api/auth/delete/resetToken', [
  'App\Controllers\AuthController',
  'deleteResetToken'
]);

$map->post('save.person', '/api/person', [
  'App\Controllers\PeopleController',
  'savePerson'
]);

$map->post('save.user', '/api/user', [
  'App\Controllers\UserController',
  'saveUser'
]);

$map->put('update.person', '/api/person', [
  'App\Controllers\PeopleController',
  'updatePerson'
]);

$map->put('update.password', '/api/password', [
  'App\Controllers\UserController',
  'updatePassword'
]);

$map->put('update.password.forget', '/api/recover/password', [
  'App\Controllers\UserController',
  'updateAndRecoverPassword'
]);

$map->patch('cancell.person', '/api/person', [
  'App\Controllers\PeopleController',
  'cancellPerson'
]);

$map->delete('delete.user', '/api/user', [
  'App\Controllers\UserController',
  'deleteUser'
]);

$map->get('get.resource', '/api/resource',  [
  'App\Controllers\ResourcesController',
  'getResource'
]);

$map->get('get.users', '/api/users', [
  'App\Controllers\UserController',
  'getUsers'
]);

$map->get('get.user', '/api/user',  [
  'App\Controllers\UserController',
  'getUser'
]);

$map->get('get.people', '/api/people', [
  'App\Controllers\PeopleController',
  'getPeople'
]);

$map->get('get.person', '/api/person', [
  'App\Controllers\PeopleController',
  'getPerson'
]);

$map->get('get.cancelled', '/api/cancelled', [
  'App\Controllers\PeopleController',
  'getCancelled'
]);

$map->get('get.scheduling', '/api/scheduling',  [
  'App\Controllers\SchedulingController',
  'getScheduling'
]);

$map->get('get.deans', '/api/deans', [
  'App\Controllers\PeopleController',
  'getDeans'
]);

$map->get('get.reports', '/api/reports', [
  'App\Controllers\StatisticsController',
  'getReports'
]);

$map->get('get.reports.counts', '/api/reports/counts', [
  'App\Controllers\StatisticsController',
  'getReportsCounts'
]);

$map->get('get.reports.count', '/api/reports/count', [
  'App\Controllers\StatisticsController',
  'getReportsCount'
]);

$map->get('get.statistics.daily', '/api/statistics/daily', [
  'App\Controllers\StatisticsController',
  'getStatisticsDaily'
]);

$map->get('get.statistics.scheduled', '/api/statistics/scheduled', [
  'App\Controllers\StatisticsController',
  'getStatisticsScheduled'
]);

$map->get('get.statistics.daily.alltime', '/api/statistics/daily/alltime', [
  'App\Controllers\StatisticsController',
  'getMostAgendatedDailyAlltime'
]);

$map->get('get.statistics.scheduled.alltime', '/api/statistics/scheduled/alltime', [
  'App\Controllers\StatisticsController',
  'getMostAgendatedScheduledAlltime'
]);

$map->get('get.statistics.daily.onrange', '/api/statistics/daily/onrange', [
  'App\Controllers\StatisticsController',
  'getMostAgendatedDailyOnRange'
]);

$map->get('get.statistics.scheduled.onrange', '/api/statistics/scheduled/onrange', [
  'App\Controllers\StatisticsController',
  'getMostAgendatedScheduledOnRange'
]);

// Get the matching route of the globals variables
$route = $routerContainer->getMatcher()->match(
  ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
  )
);

// Using Cors
CorsMiddleware::useCors();

// Execute the action of the matching route
if ($route) {
  // Get the handler of the route
  $handler = $route->handler;
  
  // Separate the name of the class and the method
  list($controller, $method) = $handler;

  // Create an instance of the controller class
  $controllerInstance = new $controller();

  // Execute the method of the controller class
  return $controllerInstance->$method();
} 

// Route not found
echo json_encode([
  'error' => 'Error: Not Found 404'
]);
