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
    
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getReports($_GET['start'], $_GET['end']));
  }

  public static function getReportsCounts()
  {
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getReportsCounts());
  }

  public static function getReportsCount()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getReportsCount($_GET['start'], $_GET['end']));
  }

  public static function getStatisticsDaily()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getStaticsDaily($_GET['start'], $_GET['end']));
  }

  public static function getStatisticsScheduled()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getStaticsScheduled($_GET['start'], $_GET['end']));
  }

  public static function getMostAgendatedDailyAlltime()
  {
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getMostAgendatedDailyAlltime());
  }

  public static function getMostAgendatedScheduledAlltime()
  {
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getMostAgendatedScheduledAlltime());
  }

  public static function getMostAgendatedDailyOnRange()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getMostAgendatedDailyOnRange($_GET['start'], $_GET['end']));
  }

  public static function getMostAgendatedScheduledOnRange()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $statisticsModel = new StatisticsModel();
    echo json_encode($statisticsModel->getMostAgendatedScheduledOnRange($_GET['start'], $_GET['end']));
  }
}
