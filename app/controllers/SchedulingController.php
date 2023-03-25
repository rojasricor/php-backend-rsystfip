<?php

namespace app\controllers;

class SchedulingController
{
  static function getScheduled($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT people_schedule.person_id AS id, registered_people.name AS title, people_schedule.start_date AS start, people_schedule.end_date AS end, people_schedule.color AS color FROM people_schedule INNER JOIN registered_people ON registered_people.id = people_schedule.person_id WHERE start_date >= ? AND start_date <= ? AND status = 'presence'");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function cancell($id, $date)
  {
    $db = Database::get();
    $statement = $db->prepare("UPDATE people_schedule SET people_schedule.status = 2 WHERE people_schedule.person_id = ? AND start_date = ?");
    return $statement->execute([$id, $date]);
  }
}
