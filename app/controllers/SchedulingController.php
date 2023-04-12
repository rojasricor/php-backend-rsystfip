<?php

namespace App\controllers;

class SchedulingController
{
  static function getAll($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT scheduling.person_id AS id, people.name AS title, scheduling.start_date AS start, scheduling.end_date AS end, scheduling.color AS color FROM scheduling INNER JOIN people ON people.id = scheduling.person_id WHERE start_date >= ? AND start_date <= ? AND status = 'scheduled'");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function cancell($id, $date)
  {
    $db = Database::get();
    $statement = $db->prepare("UPDATE scheduling SET scheduling.status = 2 WHERE scheduling.person_id = ? AND start_date = ?");
    return $statement->execute([$id, $date]);
  }
}
