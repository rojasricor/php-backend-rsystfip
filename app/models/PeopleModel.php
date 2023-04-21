<?php

namespace App\Models;

class PeopleModel extends BaseModel
{
  public function save($name, $tipo, $numero, $asunt)
  {
    $statement = $this->db->prepare("INSERT INTO people(name, id_doc, num_doc, text_asunt) VALUES (?, ?, ?, ?)");
    return $statement->execute([$name, $tipo, $numero, $asunt]);
  }

  public function schedule($name, $tipo, $numero, $type_person, $facultad, $asunt, $color, $date, $start, $end, $status)
  {
    $statement = $this->db->prepare("INSERT INTO people VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([NULL, $name, $tipo, $numero, $type_person, $facultad, $asunt]);
    $lastId = $this->getLast()->id;
    $timeModel = new TimeModel();
    $date ? $date : $date = $timeModel->todayDate();
    $start ? $start : $start = $timeModel->todayDate();
    $end ? $end : $end = $timeModel->todayDate();
    $time = $timeModel->nowHour();
    $peopleDataModel = new PeopleDataModel();
    return $peopleDataModel->save($lastId, $date, $start, $end, $time, $status, $color);
  }

  public function saveDeans($cc, $name, $facultie)
  {
    $statement = $this->db->prepare("SELECT _id FROM deans WHERE _id = ?");
    $statement->execute([$cc]);
    $deanExists = $statement->fetchObject();
    if (!$deanExists) {
      $statement = $db->prepare("INSERT INTO deans VALUES (?, ?, ?)");
      return $statement->execute([$cc, $name, $facultie]);
    }
  }

  public function getLast()
  {
    $statement = $this->db->query("SELECT id FROM people ORDER BY id DESC");
    return $statement->fetchObject();
  }

  public function getOneById($id)
  {
    $statement = $this->db->prepare("SELECT * FROM people WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public function update($name, $tipo, $numero, $type_person, $facultad, $asunt, $id)
  {
    $statement = $this->db->prepare("UPDATE people SET name = ?, id_doc = ?, num_doc = ?, person_type = ?, facultad = ?, text_asunt = ?  WHERE id = ?");
    return $statement->execute([$name, $tipo, $numero, $type_person, $facultad, $asunt, $id]);
  }

  public function getAll()
  {
    $statement = $this->db->query("SELECT p.id, p.name, d.document as ty_doc, c.category, p.facultad, d.description, p.num_doc, f.name AS fac, p.text_asunt FROM people p, documents d, faculties f, categories c WHERE p.id_doc = d.id AND p.facultad = f.id AND p.person_type = c.id ORDER BY p.id DESC");
    return $statement->fetchAll();
  }

  public function getCancelled()
  {
    $statement = $this->db->query("SELECT p.id, p.name, d.document as ty_doc, c.category, p.facultad, d.description, p.num_doc, f.name AS fac, l.cancelled_asunt FROM people p, documents d, faculties f, categories c, cancelled l, scheduling s WHERE p.id_doc = d.id AND p.id = l.person_id AND s.person_id = l.person_id AND s.status = 'cancelled' AND p.facultad = f.id AND p.person_type = c.id ORDER BY p.id DESC");
    return $statement->fetchAll();
  }

  public function getDeans()
  {
    $statement = $this->db->query("SELECT * FROM deans");
    return $statement->fetchAll();
  }
}
