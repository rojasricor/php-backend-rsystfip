<?php

namespace App\Controllers;

use App\Models\StatisticsModel;

class StatisticsController
{
  private $statisticsModel;
  
  public function __construct() {
    $this->statisticsModel = new StatisticsModel();
  }

  public function getReports()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getReports($_GET['start'], $_GET['end']));
  }

  public function getReportsCounts()
  {
    echo json_encode($this->statisticsModel->getReportsCounts());
  }

  public function getReportsCount()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getReportsCount($_GET['start'], $_GET['end']));
  }

  public function getStatisticsDaily()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getStaticsDaily($_GET['start'], $_GET['end']));
  }

  public function getStatisticsScheduled()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getStaticsScheduled($_GET['start'], $_GET['end']));
  }

  public function getMostAgendatedDailyAlltime()
  {
    echo json_encode($this->statisticsModel->getMostAgendatedDailyAlltime());
  }

  public function getMostAgendatedScheduledAlltime()
  {
    echo json_encode($this->statisticsModel->getMostAgendatedScheduledAlltime());
  }

  public function getMostAgendatedDailyOnRange()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getMostAgendatedDailyOnRange($_GET['start'], $_GET['end']));
  }

  public function getMostAgendatedScheduledOnRange()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getMostAgendatedScheduledOnRange($_GET['start'], $_GET['end']));
  }
}
