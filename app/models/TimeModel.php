<?php

namespace App\Models;

use Datetime;

class TimeModel
{
  private Datetime $date;

  public function __construct() {
    date_default_timezone_set('America/Bogota');
    $this->date = new Datetime;
  }

  public function todayDate(): string
  {
    return $this->date->format('Y-m-d');
  }

  public function nowHour(): string
  {
    return $this->date->format('h:i:s');
  }
}
