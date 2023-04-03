<?php

namespace App\controllers;

class PeopleController
{
  static function save($name, $tipo, $numero, $asunt)
  {
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO people(name, id_doc, num_doc, text_asunt) VALUES (?, ?, ?, ?)");
    return $statement->execute([$name, $tipo, $numero, $asunt]);
  }

  static function schedule($name, $tipo, $numero, $type_person, $facultad, $asunt, $color, $date, $start, $end, $status)
  {
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO people VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([NULL, $name, $tipo, $numero, $type_person, $facultad, $asunt]);
    $lastId = self::getLast()->id;
    $date ? $date : $date = TimeController::todayDate();
    $start ? $start : $start = TimeController::todayDate();
    $end ? $end : $end = TimeController::todayDate();
    $time = TimeController::nowHour();
    return PeopleDataController::save($lastId, $date, $start, $end, $time, $status, $color);
  }

  static function saveStaffDeans($cc, $name, $facultie)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT cc FROM deans WHERE cc = ?");
    $statement->execute([$cc]);
    $deanExists = $statement->fetchObject();
    if (!$deanExists) {
      $statement = $db->prepare("INSERT INTO deans VALUES (?, ?, ?)");
      return $statement->execute([$cc, $name, $facultie]);
    }
  }

  static function getLast()
  {
    $db = Database::get();
    $statement = $db->query("SELECT id FROM people ORDER BY id DESC");
    return $statement->fetchObject();
  }

  static function getOneById($id)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT * FROM people WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  static function update($name, $tipo, $numero, $type_person, $facultad, $asunt, $id)
  {
    $db = Database::get();
    $statement = $db->prepare("UPDATE people SET name = ?, id_doc = ?, num_doc = ?, person_type = ?, facultad = ?, text_asunt = ?  WHERE id = ?");
    return $statement->execute([$name, $tipo, $numero, $type_person, $facultad, $asunt, $id]);
  }

  static function getAll()
  {
    $db = Database::get();
    $statement = $db->query("SELECT p.id, p.name, d.document as ty_doc, c.person, p.facultad, d.description, p.num_doc, f.name AS fac, p.text_asunt FROM people p, documents d, faculties f, categories c WHERE p.id_doc = d.id AND p.facultad = f.id AND p.person_type = c.id ORDER BY id DESC");
    return $statement->fetchAll();
  }

  static function getDeans()
  {
    $db = Database::get();
    $statement = $db->query("SELECT * FROM deans");
    return $statement->fetchAll();
  }

  static function search($search)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT p.id, p.name, d.document as ty_doc, c.person, p.facultad, d.description, p.num_doc, f.name AS fac, p.text_asunt FROM people p, documents d, faculties f, categories c WHERE (e.id = ? OR p.num_doc = ? OR p.name LIKE ?) AND p.id_doc = d.id AND p.facultad = f.id AND p.person_type = c.id ORDER BY id ASC");
    $statement->execute([$search, $search, "$search%"]);
    return $statement->fetchAll();
  }
}
