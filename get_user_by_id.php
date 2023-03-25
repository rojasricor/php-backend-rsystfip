<?php

if (!isset($_GET['role'])) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
$user = app\controllers\UserController::getOneById($_GET['role']);

if (!$user) {
  http_response_code(404);
  exit('not found');
}

echo json_encode($user);
