<?php

namespace App\Models;

class StatisticsModel extends BaseModel
{
  public function getReports(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT p.name, s.start_date AS date, s.modification AS time, SUM(CASE WHEN s.status = 'scheduled' THEN 1 ELSE 0 END) AS scheduling_count, SUM(CASE WHEN s.status = 'daily' THEN 1 ELSE 0 END) AS daily_count, c.category, c.id AS id_person FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.date_filter >= ? AND s.date_filter <= ? GROUP BY s.person_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }
  
  public function getStaticsDaily(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT SUM(CASE WHEN s.status = 'daily' THEN 1 ELSE 0 END) AS scheduling_count, c.category FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.start_date >= ? AND s.start_date <= ? GROUP BY p.category_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getStaticsScheduled(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT SUM(CASE WHEN s.status = 'scheduled' THEN 1 ELSE 0 END) AS scheduling_count, c.category FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.start_date >= ? AND s.start_date <= ? GROUP BY p.category_id");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getReportsCount(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT c.category, COUNT(*) AS counts FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.date_filter >= ? AND s.date_filter <= ? GROUP BY p.category_id, c.category ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getMostAgendatedDailyOnRange(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT c.category, COUNT(*) AS counts FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.status = 'daily' AND s.date_filter >= ? AND s.date_filter <= ? GROUP BY p.category_id, c.category ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getMostAgendatedScheduledOnRange(string $start, string $end): array
  {
    $statement = $this->db->prepare("SELECT c.category, COUNT(*) AS counts FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.status = 'scheduled' AND s.date_filter >= ? AND s.date_filter <= ? GROUP BY p.category_id, c.category ORDER BY counts DESC LIMIT 10");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
  }

  public function getReportsCounts(): array
  {
    $statement = $this->db->query("SELECT c.category, COUNT(*) AS counts FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id GROUP BY p.category_id, c.category ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  public function getMostAgendatedDailyAlltime(): array
  {
    $statement = $this->db->query("SELECT c.category, COUNT(*) AS counts FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.status = 'daily' GROUP BY p.category_id, c.category ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }

  public function getMostAgendatedScheduledAlltime(): array
  {
    $statement = $this->db->query("SELECT c.category, COUNT(*) AS counts FROM scheduling s INNER JOIN people p ON p.id = s.person_id INNER JOIN categories c ON c.id = p.category_id WHERE s.status = 'scheduled' GROUP BY p.category_id, c.category ORDER BY counts DESC LIMIT 10");
    return $statement->fetchAll();
  }
}
