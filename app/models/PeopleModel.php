<?php

namespace App\Models;

class PeopleModel extends BaseModel
{
  public function save($name, $tipo, $numero, $asunt)
  {
    $statement = $this->db->prepare("INSERT INTO people (name, document_id, document_number, come_asunt) VALUES (?, ?, ?, ?)");
    return $statement->execute([$name, $tipo, $numero, $asunt]);
  }

  public function schedule($name, $tipo, $numero, $type_person, $telCntct, $emailCtc, $facultie_id, $asunt, $color, $date, $start, $end, $status)
  {
    $statement = $this->db->prepare("INSERT INTO people (name, document_id, document_number, telephone, email, category_id, facultie_id, come_asunt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([
      $name,
      $tipo,
      $numero,
      $telCntct,
      $emailCtc,
      $type_person,
      $facultie_id,
      $asunt
    ]);
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
      $statement = $this->db->prepare("INSERT INTO deans (_id, dean, facultie_id) VALUES (?, ?, ?)");
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

  public function update($name, $tipo, $numero, $type_person, $facultie_id, $asunt, $id)
  {
    $statement = $this->db->prepare("UPDATE people SET name = ?, document_id = ?, document_number = ?, category_id = ?, facultie_id = ?, come_asunt = ?  WHERE id = ?");
    return $statement->execute([
      $name,
      $tipo,
      $numero,
      $type_person,
      $facultie_id,
      $asunt,
      $id
    ]);
  }

  public function getAll()
  {
    $statement = $this->db->query("SELECT p.id, p.name, d.document as ty_doc, c.category, p.facultie_id, d.description, p.document_number, f.facultie, p.come_asunt FROM people p, documents d, faculties f, categories c WHERE p.document_id = d.id AND p.facultie_id = f.id AND p.category_id = c.id ORDER BY p.id DESC");
    return $statement->fetchAll();
  }

  public function getCancelled()
  {
    $statement = $this->db->query("SELECT p.id, p.name, d.document as ty_doc, c.category, p.facultie_id, d.description, p.document_number, f.facultie, l.cancelled_asunt FROM people p, documents d, faculties f, categories c, cancelled l, scheduling s WHERE p.document_id = d.id AND p.id = l.person_id AND s.person_id = l.person_id AND s.status = 'cancelled' AND p.facultie_id = f.id AND p.category_id = c.id ORDER BY p.id DESC");
    return $statement->fetchAll();
  }

  public function getDeans()
  {
    $statement = $this->db->query("SELECT * FROM deans");
    return $statement->fetchAll();
  }
}
