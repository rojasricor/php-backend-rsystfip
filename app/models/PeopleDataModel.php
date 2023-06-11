<?php

namespace App\Models;

class PeopleDataModel extends BaseModel
{
  public function save(
    string $id,
    string $date,string $start_date,
    string $end_date,
    string $time,
    string $status,
    string $color
  ): bool
  {
    $statement = $this->db->prepare("INSERT INTO scheduling (person_id, date_filter, start_date, end_date, modification, status, color) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $statement->execute([
      $id,
      $date,
      $start_date,
      $end_date,
      $time,
      $status,
      $color
    ]);
  }
}
