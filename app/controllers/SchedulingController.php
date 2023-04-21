<?php

namespace App\Controllers;

use App\Models\SchedulingModel;

class SchedulingController
{
  public function getScheduling()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $schedulingModel = new SchedulingModel();
    echo json_encode($schedulingModel->getAll($_GET['start'], $_GET['end']));
  }
}
