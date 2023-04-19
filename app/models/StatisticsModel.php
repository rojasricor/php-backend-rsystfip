<?php

namespace App\Models;

class StatisticsModel
{
  public static function getReports($start, $end)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT people.name, scheduling.start_date AS date, scheduling.modification AS time, SUM(CASE WHEN status = 'scheduled' THEN 1 ELSE 0 END) AS scheduling_count, SUM(CASE WHEN status = 'daily' THEN 1 ELSE 0 END) AS daily_count, categories.person, categories.id as id_person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }
  
  public static function getStaticsDaily($start, $end)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT SUM(CASE WHEN status = 'daily' THEN 1 ELSE 0 END) AS scheduling_count, categories.person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE start_date >= ? AND start_date <= ? AND categories.id = people.person_type GROUP BY person_type");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public static function getStaticsScheduled($start, $end)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT SUM(CASE WHEN status = 'scheduled' THEN 1 ELSE 0 END) AS scheduling_count, categories.person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE start_date >= ? AND start_date <= ? AND categories.id = people.person_type GROUP BY person_type");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public static function getReportsCount($start, $end)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public static function getMostAgendatedDailyOnRange($start, $end)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'daily' AND date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public static function getMostAgendatedScheduledOnRange($start, $end)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'scheduled' AND date_filter >= ? AND date_filter <= ? AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public static function getReportsCounts()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  public static function getMostAgendatedDailyAlltime()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'daily' AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  public static function getMostAgendatedScheduledAlltime()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT categories.person, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'scheduled' AND categories.id = people.person_type GROUP BY person_type, categories.person ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }
}
