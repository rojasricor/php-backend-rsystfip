<?php

namespace App\Models;

class SchedulingModel extends BaseModel
{
  public function getAll(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT scheduling.person_id AS id, people.name AS title, scheduling.start_date AS start, scheduling.end_date AS end, scheduling.color AS color FROM scheduling INNER JOIN people ON people.id = scheduling.person_id WHERE start_date >= ? AND start_date <= ? AND status = 'scheduled'");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function findCiteById(string $id): object | bool
  {
    $statement = $this->db->prepare("SELECT people.name, people.telephone AS tel, people.email AS email FROM scheduling INNER JOIN people ON people.id = scheduling.person_id WHERE scheduling.person_id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public function cancell(string $id, string $date, string $cancelled_asunt): bool
  {
    $statement = $this->db->prepare("UPDATE scheduling SET scheduling.status = 'cancelled' WHERE scheduling.person_id = ? AND scheduling.start_date = ?");
    $statement->execute([$id, $date]);
    $statement = $this->db->prepare("INSERT INTO cancelled (person_id, cancelled_asunt) VALUES (?, ?)");
    return $statement->execute([$id, $cancelled_asunt]);
  }
}
