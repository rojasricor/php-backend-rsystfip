<?php

namespace app\controllers;

use date;

date_default_timezone_set('America/Bogota');

class TimeController
{
  static function todayDate()
  {
    return date('Y-m-d');
  }

  static function nowHour()
  {
    return date('h:i:s');
  }

  static function todayDateTime()
  {
    return self::todayDate() . '_' . self::nowHour();
  }
}
