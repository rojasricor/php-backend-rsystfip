<?php

namespace App\Controllers;

use App\Models\SchedulingModel;

class SchedulingController
{
  private SchedulingModel $schedulingModel;

  public function __construct()
  {
    $this->schedulingModel = new SchedulingModel;
  }

  public function getScheduling(): void
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode($this->schedulingModel->getAll($_GET['start'], $_GET['end']));
  }
}
