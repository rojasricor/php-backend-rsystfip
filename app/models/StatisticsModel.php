<?php

namespace App\Models;

class StatisticsModel extends BaseModel
{
  public function getReports($start, $end)
  {
    $statement = $this->db->prepare("SELECT people.name, scheduling.start_date AS date, scheduling.modification AS time, SUM(CASE WHEN status = 'scheduled' THEN 1 ELSE 0 END) AS scheduling_count, SUM(CASE WHEN status = 'daily' THEN 1 ELSE 0 END) AS daily_count, categories.category, categories.id as id_person FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE date_filter >= ? AND date_filter <= ? AND categories.id = people.category_id GROUP BY scheduling.person_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }
  
  public function getStaticsDaily($start, $end)
  {
    $statement = $this->db->prepare("SELECT SUM(CASE WHEN status = 'daily' THEN 1 ELSE 0 END) AS scheduling_count, categories.category FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE start_date >= ? AND start_date <= ? AND categories.id = people.category_id GROUP BY people.category_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getStaticsScheduled($start, $end)
  {
    $statement = $this->db->prepare("SELECT SUM(CASE WHEN status = 'scheduled' THEN 1 ELSE 0 END) AS scheduling_count, categories.category FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE start_date >= ? AND start_date <= ? AND categories.id = people.category_id GROUP BY people.category_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getReportsCount($start, $end)
  {
    $statement = $this->db->prepare("SELECT categories.category, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE date_filter >= ? AND date_filter <= ? AND categories.id = people.category_id GROUP BY people.category_id, categories.category ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getMostAgendatedDailyOnRange($start, $end)
  {
    $statement = $this->db->prepare("SELECT categories.category, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'daily' AND date_filter >= ? AND date_filter <= ? AND categories.id = people.category_id GROUP BY people.category_id, categories.category ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getMostAgendatedScheduledOnRange($start, $end)
  {
    $statement = $this->db->prepare("SELECT categories.category, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'scheduled' AND date_filter >= ? AND date_filter <= ? AND categories.id = people.category_id GROUP BY people.category_id, categories.category ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getReportsCounts()
  {
    $statement = $this->db->query("SELECT categories.category, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE categories.id = people.category_id GROUP BY people.category_id, categories.category ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  public function getMostAgendatedDailyAlltime()
  {
    $statement = $this->db->query("SELECT categories.category, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'daily' AND categories.id = people.category_id GROUP BY people.category_id, categories.category ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  public function getMostAgendatedScheduledAlltime()
  {
    $statement = $this->db->query("SELECT categories.category, COUNT(*) AS counts FROM scheduling INNER JOIN people ON people.id = scheduling.person_id, categories WHERE scheduling.status = 'scheduled' AND categories.id = people.category_id GROUP BY people.category_id, categories.category ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }
}
