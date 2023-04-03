<?php

namespace App\controllers;

class StatisticsController
{
  static function getReports($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT people.name, scheduling.start_date AS date, scheduling.modification AS time, SUM(CASE WHEN status = 'presence' THEN 1 ELSE 0 END) AS presence_count, SUM(CASE WHEN status = 'absence' THEN 1 ELSE 0 END) AS absence_count, categories.person, categories.id as id_person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  /**
   * If you want get statistics for all scheduling, check the next: scheduling.status = 'absence' || 'presence'
   * @param  [type]
   * @param  [type]
   * @return [type]
   */
  static function getStaticsDaily($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT SUM(CASE WHEN status = 'absence' THEN 1 ELSE 0 END) AS presence_count, categories.person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE start_date >= ? AND start_date <= ? AND categories.id = people.person_type GROUP BY person_type");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getStaticsScheduled($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT SUM(CASE WHEN status = 'presence' THEN 1 ELSE 0 END) AS presence_count, categories.person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE start_date >= ? AND start_date <= ? AND categories.id = people.person_type GROUP BY person_type");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getReportsCount($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getMostAgendatedDailyOnRange($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'absence' AND date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getMostAgendatedScheduledOnRange($start, $end)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'presence' AND date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  static function getReportsCounts()
  {
    $db = Database::get();
    $statement = $db->query("SELECT categories.person, COUNT(*) AS counts, MIN(scheduling.date_filter) as init FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  static function getMostAgendatedDailyAlltime()
  {
    $db = Database::get();
    $statement = $db->query("SELECT categories.person, COUNT(*) AS counts, MIN(scheduling.date_filter) as init FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'absence' AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  static function getMostAgendatedScheduledAlltime()
  {
    $db = Database::get();
    $statement = $db->query("SELECT categories.person, COUNT(*) AS counts, MIN(scheduling.date_filter) as init FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'presence' AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }
}
