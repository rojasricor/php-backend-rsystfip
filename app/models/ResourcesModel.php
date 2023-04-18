<?php

namespace App\Models;

class ResourcesModel
{
  static function getDocuments()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT id, description FROM documents");
    return $statement->fetchAll();
  }

  static function getFaculties()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT * FROM faculties");
    return $statement->fetchAll();
  }

  static function getCategories()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT * FROM categories");
    return $statement->fetchAll();
  }
}
