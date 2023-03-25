<?php

if (!isset($_GET['start']) || !isset($_GET['end'])) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
echo json_encode(app\controllers\StatisticsController::getStaticsOnRange($_GET['start'], $_GET['end']));