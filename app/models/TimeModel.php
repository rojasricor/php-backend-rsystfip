<?php

namespace App\Models;

class TimeModel
{
  public function todayDate()
  {
    return date('Y-m-d');
  }

  public function nowHour()
  {
    return date('h:i:s');
  }
}
