<?php

namespace App\Models;

class PeopleDataModel extends BaseModel
{
  public function save($id, $date, $start_date, $end_date, $time, $status, $color)
  {
    $statement = $this->db->prepare("INSERT INTO scheduling VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $statement->execute([$id, $date, $start_date, $end_date, $time, $status, $color]);
  }
}
