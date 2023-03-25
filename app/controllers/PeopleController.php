<?php

namespace app\controllers;

class PeopleController
{
  static function save($name, $tipo, $numero, $asunt)
  {
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO registered_people(name, id_doc, num_doc, text_asunt) VALUES (?, ?, ?, ?)");
    return $statement->execute([$name, $tipo, $numero, $asunt]);
  }

  static function schedule($name, $tipo, $numero, $type_person, $facultad, $asunt, $color, $date, $start, $end, $status)
  {
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO registered_people VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([NULL, $name, $tipo, $numero, $type_person, $facultad, $asunt]);
    $lastId = self::getLast()->id;
    $date ? $date : $date = TimeController::todayDate();
    $start ? $start : $start = TimeController::todayDate();
    $end ? $end : $end = TimeController::todayDate();
    $time = TimeController::nowHour();
    return PeopleDataController::saveAuthomatic($lastId, $date, $start, $end, $time, $status, $color);
  }

  static function saveStaffDeans($cc, $name, $facultie)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT cc FROM decanos_itfip WHERE cc = ?");
    $statement->execute([$cc]);
    $deanExists = $statement->fetchObject();
    if (!$deanExists) {
      $statement = $db->prepare("INSERT INTO decanos_itfip VALUES (?, ?, ?)");
      return $statement->execute([$cc, $name, $facultie]);
    }
  }

  static function getLast()
  {
    $db = Database::get();
    $statement = $db->query("SELECT id FROM registered_people ORDER BY id DESC");
    return $statement->fetchObject();
  }

  static function getOneById($id)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT * FROM registered_people WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  static function update($name, $tipo, $numero, $type_person, $facultad, $asunt, $id)
  {
    $db = Database::get();
    $statement = $db->prepare("UPDATE registered_people SET name = ?, id_doc = ?, num_doc = ?, person_type = ?, facultad = ?, text_asunt = ?  WHERE id = ?");
    return $statement->execute([$name, $tipo, $numero, $type_person, $facultad, $asunt, $id]);
  }

  static function getAll()
  {
    $db = Database::get();
    $statement = $db->query("SELECT e.id, e.name, d.document as ty_doc, p.person, e.facultad, d.description, e.num_doc, f.name AS fac, e.text_asunt FROM registered_people e, document d, faculties f, person_type p WHERE e.id_doc = d.id AND e.facultad = f.id AND e.person_type = p.id ORDER BY id DESC");
    return $statement->fetchAll();
  }

  static function getStaffDeans()
  {
    $db = Database::get();
    $statement = $db->query("SELECT * FROM decanos_itfip");
    return $statement->fetchAll();
  }

  static function search($search)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT e.id, e.name, d.document as ty_doc, p.person, e.facultad, d.description, e.num_doc, f.name AS fac, e.text_asunt FROM registered_people e, document d, faculties f, person_type p WHERE (e.id = ? OR e.num_doc = ? OR e.name LIKE ?) AND e.id_doc = d.id AND e.facultad = f.id AND e.person_type = p.id ORDER BY id ASC");
    $statement->execute([$search, $search, "$search%"]);
    return $statement->fetchAll();
  }
}
