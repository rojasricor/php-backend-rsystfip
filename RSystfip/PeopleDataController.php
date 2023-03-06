<?php

namespace RSystfip;

class PeopleDataController
{
  static function save($start_date, $time, $people)
  {
    self::delete($start_date);
    $db = Database::get();
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO people_schedule(person_id, date_filter, modification, status) VALUES (?, ?, ?, ?)");
    foreach ($people as $person) {
      $statement->execute([$person->id, $start_date, $time, $person->status]);
    }
    $db->commit();
    return true;
  }

  static function saveAuthomatic($id, $date, $start_date, $end_date, $time, $status, $color)
  {
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO people_schedule VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $statement->execute([$id, $date, $start_date, $end_date, $time, $status, $color]);
  }

  static function delete($start_date)
  {
    $db = Database::get();
    $statement = $db->prepare("DELETE FROM people_schedule WHERE date_filter = ?");
    return $statement->execute([$start_date]);
  }

  static function getByDate($start_date)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT person_id, status FROM people_schedule WHERE date_filter = ?");
    $statement->execute([$start_date]);
    return $statement->fetchAll();
  }
}
