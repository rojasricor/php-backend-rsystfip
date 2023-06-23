<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\JsonResponse;
use App\Controllers\{
  AuthController,
  PeopleController,
  ResourcesController,
  SchedulingController,
  StatisticsController,
  UserController
};
use App\Middlewares\{
  CorsMiddleware,
  JwtMiddleware,
  RoleMiddleware
};

// Using Cors
(new CorsMiddleware())();

// Create an instance of route container
$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

// Routes
$map->post('auth', '/api/auth', [
  AuthController::class,
  'auth',
  []
]);

$map->post('auth.validate', '/api/auth/validate/token/session', [
  AuthController::class,
  'validateSession',
  []
]);

$map->post('auth.recover.password', '/api/auth/recover/password', [
  UserController::class,
  'recoverPassword',
  []
]);

$map->post('verify.resetToken', '/api/auth/verify/resetToken', [
  UserController::class,
  'verifyResetToken',
  []
]);

$map->delete('delete.resetToken', '/api/auth/delete/resetToken', [
  UserController::class,
  'deleteResetToken',
  []
]);

$map->post('save.person', '/api/person', [
  PeopleController::class,
  'savePerson',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->post('save.user', '/api/user', [
  UserController::class,
  'saveUser',
  [new JwtMiddleware, new RoleMiddleware(['admin'])]
]);

$map->put('update.person', '/api/person', [
  PeopleController::class,
  'updatePerson',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->put('update.password', '/api/password', [
  UserController::class,
  'updatePassword',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->put('update.password.forget', '/api/recover/password', [
  UserController::class,
  'updateAndRecoverPassword',
  []
]);

$map->patch('cancell.person', '/api/person', [
  PeopleController::class,
  'cancellPerson',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->delete('delete.user', '/api/user', [
  UserController::class,
  'deleteUser',
  [new JwtMiddleware, new RoleMiddleware(['admin'])]
]);

$map->get('get.resource', '/api/resource',  [
  ResourcesController::class,
  'getResource',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->get('get.users', '/api/users', [
  UserController::class,
  'getUsers',
  [new JwtMiddleware, new RoleMiddleware(['admin'])]
]);

$map->get('get.user', '/api/user',  [
  UserController::class,
  'getUser',
  [new JwtMiddleware, new RoleMiddleware(['admin', 'rector', 'secretaria'])]
]);

$map->get('get.people', '/api/people', [
  PeopleController::class,
  'getPeople',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->get('get.person', '/api/person', [
  PeopleController::class,
  'getPerson',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->get('get.cancelled', '/api/cancelled', [
  PeopleController::class,
  'getCancelled',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin', 'rector'])]
]);

$map->get('get.scheduling', '/api/scheduling',  [
  SchedulingController::class,
  'getScheduling',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->get('get.scheduling.all', '/api/scheduling/all',  [
  SchedulingController::class,
  'getAllScheduling',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->get('get.deans', '/api/deans', [
  PeopleController::class,
  'getDeans',
  [new JwtMiddleware, new RoleMiddleware(['rector', 'secretaria', 'admin'])]
]);

$map->get('get.reports', '/api/reports', [
  StatisticsController::class,
  'getReports',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.reports.counts', '/api/reports/counts', [
  StatisticsController::class,
  'getReportsCounts',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.reports.count', '/api/reports/count', [
  StatisticsController::class,
  'getReportsCount',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.statistics.daily', '/api/statistics/daily', [
  StatisticsController::class,
  'getStatisticsDaily',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.statistics.scheduled', '/api/statistics/scheduled', [
  StatisticsController::class,
  'getStatisticsScheduled',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.statistics.daily.alltime', '/api/statistics/daily/alltime', [
  StatisticsController::class,
  'getMostAgendatedDailyAlltime',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.statistics.scheduled.alltime', '/api/statistics/scheduled/alltime', [
  StatisticsController::class,
  'getMostAgendatedScheduledAlltime',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.statistics.daily.onrange', '/api/statistics/daily/onrange', [
  StatisticsController::class,
  'getMostAgendatedDailyOnRange',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

$map->get('get.statistics.scheduled.onrange', '/api/statistics/scheduled/onrange', [
  StatisticsController::class,
  'getMostAgendatedScheduledOnRange',
  [new JwtMiddleware, new RoleMiddleware(['secretaria', 'admin'])]
]);

// Get the matching route of the globals variables
$route = $routerContainer->getMatcher()->match(
  ServerRequestFactory::fromGlobals()
);

// Execute the action of the matching route
if ($route) {
  // Get the handler of the route
  $handler = $route->handler;
  
  // Separate the name of the class and the method
  list($controller, $method, $middlewares) = $handler;

  // Create an instance of the middleware class
  foreach ($middlewares as $middleware) $middleware();

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

