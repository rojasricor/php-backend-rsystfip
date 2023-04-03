<?php

namespace App\controllers;

class ResourceController
{
  static function getAllDocuments()
  {
    $db = Database::get();
    $statement = $db->query("SELECT id, description FROM document");
    return $statement->fetchAll();
  }

  static function getAllFaculties()
  {
    $db = Database::get();
    $statement = $db->query("SELECT * FROM faculties");
    return $statement->fetchAll();
  }

  static function getAllTypePersons()
  {
    $db = Database::get();
    $statement = $db->query("SELECT * FROM person_type");
    return $statement->fetchAll();
  }
}
