<?php

namespace App\Models;

class ResourcesModel extends BaseModel
{
  public function getDocuments()
  {
    $statement = $this->db->query("SELECT id, description FROM documents");
    return $statement->fetchAll();
  }

  public function getFaculties()
  {
    $statement = $this->db->query("SELECT id, facultie FROM faculties");
    return $statement->fetchAll();
  }

  public function getCategories()
  {
    $statement = $this->db->query("SELECT id, category FROM categories");
    return $statement->fetchAll();
  }
}
