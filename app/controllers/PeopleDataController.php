<?php

namespace App\Controllers;

class PeopleDataController
{
  static function save($id, $date, $start_date, $end_date, $time, $status, $color)
  {
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO scheduling VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $statement->execute([$id, $date, $start_date, $end_date, $time, $status, $color]);
  }
}
