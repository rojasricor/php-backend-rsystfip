<?php

namespace App\Controllers;

use App\Models\StatisticsModel;

class StatisticsController
{
  private StatisticsModel $statisticsModel;
  
  public function __construct()
  {
    $this->statisticsModel = new StatisticsModel();
  }

  public function getReports(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getReports($_GET['start'], $_GET['end']));
  }

  public function getReportsCounts(): void
  {
    echo json_encode($this->statisticsModel->getReportsCounts());
  }

  public function getReportsCount(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getReportsCount($_GET['start'], $_GET['end']));
  }

  public function getStatisticsDaily(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getStaticsDaily($_GET['start'], $_GET['end']));
  }

  public function getStatisticsScheduled(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getStaticsScheduled($_GET['start'], $_GET['end']));
  }

  public function getMostAgendatedDailyAlltime(): void
  {
    echo json_encode($this->statisticsModel->getMostAgendatedDailyAlltime());
  }

  public function getMostAgendatedScheduledAlltime(): void
  {
    echo json_encode($this->statisticsModel->getMostAgendatedScheduledAlltime());
  }

  public function getMostAgendatedDailyOnRange(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getMostAgendatedDailyOnRange($_GET['start'], $_GET['end']));
  }

  public function getMostAgendatedScheduledOnRange(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->statisticsModel->getMostAgendatedScheduledOnRange($_GET['start'], $_GET['end']));
  }
}
