<?php

namespace App\Models;

class SchedulingModel extends BaseModel
{
  public function getAll(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT s.person_id AS id, p.name AS title, s.start_date AS start, s.end_date AS end, s.color AS color FROM scheduling s INNER JOIN people p ON p.id = s.person_id WHERE s.status = 'scheduled' AND s.start_date >= ? AND s.start_date <= ?");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function findCiteById(string $id): object | bool
  {
    $statement = $this->db->prepare("SELECT p.name, p.telephone AS tel, p.email AS email FROM scheduling s INNER JOIN people p ON p.id = s.person_id WHERE s.person_id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public function cancell(string $id, string $date, string $cancelled_asunt): bool
  {
    $statement = $this->db->prepare("UPDATE scheduling SET status = 'cancelled' WHERE person_id = ? AND start_date = ?");
    $statement->execute([$id, $date]);
    $statement = $this->db->prepare("INSERT INTO cancelled (person_id, cancelled_asunt) VALUES (?, ?)");
    return $statement->execute([$id, $cancelled_asunt]);
  }
}
