<?php

namespace app\controllers;

class StatisticsController
{
  static function getPeopleWithPeopleCount($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT registered_people.name, people_schedule.start_date AS date, people_schedule.modification AS time, SUM(CASE WHEN status = 'presence' THEN 1 ELSE 0 END) AS presence_count, SUM(CASE WHEN status = 'absence' THEN 1 ELSE 0 END) AS absence_count, person_type.person, person_type.id as id_person FROM people_schedule INNER JOIN registered_people ON registered_people.id = people_schedule.person_id, person_type WHERE date_filter >= ? AND date_filter <= ? AND person_type.id = registered_people.person_type GROUP BY person_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getPeopleWithPeopleCountWithCategory($start, $end, $person_type)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT registered_people.name, people_schedule.start_date AS date, people_schedule.modification AS time, SUM(CASE WHEN status = 'presence' THEN 1 ELSE 0 END) AS presence_count, SUM(CASE WHEN status = 'absence' THEN 1 ELSE 0 END) AS absence_count, person_type.person, person_type.id as id_person FROM people_schedule INNER JOIN registered_people ON registered_people.id = people_schedule.person_id, person_type WHERE date_filter >= ? AND date_filter <= ? AND registered_people.person_type = ? AND person_type.id = registered_people.person_type GROUP BY person_id");
    $statement->execute([$start, $end, $person_type]);
    return $statement->fetchAll();
  }

  static function getStaticsOnRange($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT SUM(CASE WHEN status = 'presence' THEN 1 ELSE 0 END) AS presence_count, person_type.person FROM people_schedule INNER JOIN registered_people ON registered_people.id = people_schedule.person_id, person_type WHERE start_date >= ? AND start_date <= ? AND person_type.id = registered_people.person_type GROUP BY person_type");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getMostAgendatedOfAllTime()
  {
    $db = Database::get();
    $statement = $db->query("SELECT person_type.person, COUNT(*) AS counts, MIN(people_schedule.date_filter) as init FROM people_schedule INNER JOIN registered_people ON registered_people.id = people_schedule.person_id, person_type WHERE person_type.id = registered_people.person_type GROUP BY person_type, person_type.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  static function getMostAgendatedByDate($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT person_type.person, COUNT(*) AS counts FROM people_schedule INNER JOIN registered_people ON registered_people.id = people_schedule.person_id, person_type WHERE date_filter >= ? AND date_filter <= ? AND person_type.id = registered_people.person_type GROUP BY person_type, person_type.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }
}
