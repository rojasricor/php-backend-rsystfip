<?php

namespace App\controllers;

class ResourceController
{
  static function getDocuments()
  {
    $db = Database::get();
    $statement = $db->query("SELECT id, description FROM documents");
    return $statement->fetchAll();
  }

  static function getFaculties()
  {
    $db = Database::get();
    $statement = $db->query("SELECT * FROM faculties");
    return $statement->fetchAll();
  }

  static function getCategories()
  {
    $db = Database::get();
    $statement = $db->query("SELECT * FROM categories");
    return $statement->fetchAll();
  }
}
