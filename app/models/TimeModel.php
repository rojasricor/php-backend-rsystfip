<?php

namespace App\Models;

class TimeModel
{
  public function todayDate()
  {
    date_default_timezone_set('America/Bogota');
    return date('Y-m-d');
  }

  public function nowHour()
  {
    date_default_timezone_set('America/Bogota');
    return date('h:i:s');
  }
}
