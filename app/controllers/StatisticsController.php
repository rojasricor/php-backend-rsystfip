<?php

namespace App\Controllers;

use App\Models\StatisticsModel;

class StatisticsController
{
  public static function getReports()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(StatisticsModel::getReports($_GET['start'], $_GET['end']));
  }

  public static function getReportsCounts()
  {
    echo json_encode(StatisticsModel::getReportsCounts());
  }

  public static function getReportsCount()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(StatisticsModel::getReportsCount($_GET['start'], $_GET['end']));
  }

  public static function getStatisticsDaily()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(StatisticsModel::getStaticsDaily($_GET['start'], $_GET['end']));
  }

  public static function getStatisticsScheduled()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(StatisticsModel::getStaticsScheduled($_GET['start'], $_GET['end']));
  }

  public static function getMostAgendatedDailyAlltime()
  {
    echo json_encode(StatisticsModel::getMostAgendatedDailyAlltime());
  }

  public static function getMostAgendatedScheduledAlltime()
  {
    echo json_encode(StatisticsModel::getMostAgendatedScheduledAlltime());
  }

  public static function getMostAgendatedDailyOnRange()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(StatisticsModel::getMostAgendatedDailyOnRange($_GET['start'], $_GET['end']));
  }

  public static function getMostAgendatedScheduledOnRange()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(StatisticsModel::getMostAgendatedScheduledOnRange($_GET['start'], $_GET['end']));
  }
}
