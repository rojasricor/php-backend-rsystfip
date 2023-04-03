<?php

include_once 'session_check.php';
echo json_encode(app\controllers\StatisticsController::getMostAgendatedDailyOfAllTime());