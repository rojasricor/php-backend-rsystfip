<?php

namespace App\Models;

class TimeModel
{
  public static function todayDate()
  {
    return date('Y-m-d');
  }

  public static function nowHour()
  {
    return date('h:i:s');
  }
}
