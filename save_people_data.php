<?php

$payload = json_decode(file_get_contents('php://input'));
if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
echo json_encode(RSystfip\PeopleDataController::save($payload->date, $payload->time, $payload->people));
