<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\JsonResponse;
use App\Middlewares\CorsMiddleware;
use App\Controllers\{
  AuthController,
  PeopleController,
  ResourcesController,
  SchedulingController,
  StatisticsController,
  UserController
};

// Create an instance of route container
$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

// Routes
$map->post('auth', '/api/auth', [
  AuthController::class,
  'auth'
]);

$map->post('auth.validate', '/api/auth/validate/token/session', [
  AuthController::class,
  'validateSession'
]);

$map->post('auth.recover.password', '/api/auth/recover/password', [
  UserController::class,
  'recoverPassword'
]);

$map->post('verify.resetToken', '/api/auth/verify/resetToken', [
  UserController::class,
  'verifyResetToken'
]);

$map->delete('delete.resetToken', '/api/auth/delete/resetToken', [
  UserController::class,
  'deleteResetToken'
]);

$map->post('save.person', '/api/person', [
  PeopleController::class,
  'savePerson'
]);

$map->post('save.user', '/api/user', [
  UserController::class,
  'saveUser'
]);

$map->put('update.person', '/api/person', [
  PeopleController::class,
  'updatePerson'
]);

$map->put('update.password', '/api/password', [
  UserController::class,
  'updatePassword'
]);

$map->put('update.password.forget', '/api/recover/password', [
  UserController::class,
  'updateAndRecoverPassword'
]);

$map->patch('cancell.person', '/api/person', [
  PeopleController::class,
  'cancellPerson'
]);

$map->delete('delete.user', '/api/user', [
  UserController::class,
  'deleteUser'
]);

$map->get('get.resource', '/api/resource',  [
  ResourcesController::class,
  'getResource'
]);

$map->get('get.users', '/api/users', [
  UserController::class,
  'getUsers'
]);

$map->get('get.user', '/api/user',  [
  UserController::class,
  'getUser'
]);

$map->get('get.people', '/api/people', [
  PeopleController::class,
  'getPeople'
]);

$map->get('get.person', '/api/person', [
  PeopleController::class,
  'getPerson'
]);

$map->get('get.cancelled', '/api/cancelled', [
  PeopleController::class,
  'getCancelled'
]);

$map->get('get.scheduling', '/api/scheduling',  [
  SchedulingController::class,
  'getScheduling'
]);

$map->get('get.deans', '/api/deans', [
  PeopleController::class,
  'getDeans'
]);

$map->get('get.reports', '/api/reports', [
  StatisticsController::class,
  'getReports'
]);

$map->get('get.reports.counts', '/api/reports/counts', [
  StatisticsController::class,
  'getReportsCounts'
]);

$map->get('get.reports.count', '/api/reports/count', [
  StatisticsController::class,
  'getReportsCount'
]);

$map->get('get.statistics.daily', '/api/statistics/daily', [
  StatisticsController::class,
  'getStatisticsDaily'
]);

$map->get('get.statistics.scheduled', '/api/statistics/scheduled', [
  StatisticsController::class,
  'getStatisticsScheduled'
]);

$map->get('get.statistics.daily.alltime', '/api/statistics/daily/alltime', [
  StatisticsController::class,
  'getMostAgendatedDailyAlltime'
]);

$map->get('get.statistics.scheduled.alltime', '/api/statistics/scheduled/alltime', [
  StatisticsController::class,
  'getMostAgendatedScheduledAlltime'
]);

$map->get('get.statistics.daily.onrange', '/api/statistics/daily/onrange', [
  StatisticsController::class,
  'getMostAgendatedDailyOnRange'
]);

$map->get('get.statistics.scheduled.onrange', '/api/statistics/scheduled/onrange', [
  StatisticsController::class,
  'getMostAgendatedScheduledOnRange'
]);

// Get the matching route of the globals variables
$route = $routerContainer->getMatcher()->match(
  ServerRequestFactory::fromGlobals()
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
  $controllerInstance->$method();
} else {
  // Default message when endpoint not found
  $defaultMessagge = ['error' => 'Endpoint not found'];

  // Route not found
  echo json_encode($defaultMessagge); 
}

