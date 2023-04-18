<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$role = $payload->role;

include_once 'session_check.php';
echo json_encode(App\Controllers\UserController::delete($role));
