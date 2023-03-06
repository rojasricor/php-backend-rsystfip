<?php

if (!isset($_GET['date'])) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
echo json_encode(RSystfip\PeopleDataController::getByDate($_GET['date']));