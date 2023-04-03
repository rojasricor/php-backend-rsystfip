<?php

include_once 'session_check.php';
echo json_encode(App\controllers\StatisticsController::getMostAgendatedDailyOfAllTime());