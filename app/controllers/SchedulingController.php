<?php

namespace App\Controllers;

use App\Models\SchedulingModel;

class SchedulingController
{
  static function getScheduling()
  {
    if (!isset($_GET['start']) || !isset($_GET['end'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    echo json_encode(SchedulingModel::getAll($_GET['start'], $_GET['end']));
  }
}
