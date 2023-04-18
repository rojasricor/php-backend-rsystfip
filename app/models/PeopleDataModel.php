<?php

namespace App\Models;

class PeopleDataModel
{
  static function save($id, $date, $start_date, $end_date, $time, $status, $color)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("INSERT INTO scheduling VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $statement->execute([$id, $date, $start_date, $end_date, $time, $status, $color]);
  }
}
