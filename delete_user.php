<?php

if (!isset($_GET['role'])) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
echo json_encode(app\controllers\UserController::delete($_GET['role']));
