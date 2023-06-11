<?php

namespace App\Models;

class ResourcesModel extends BaseModel
{
  public function getDocuments(): array
  {
    $statement = $this->db->query("SELECT id, description FROM documents");
    return $statement->fetchAll();
  }

  public function getFaculties(): array
  {
    $statement = $this->db->query("SELECT id, facultie FROM faculties");
    return $statement->fetchAll();
  }

  public function getCategories(): array
  {
    $statement = $this->db->query("SELECT id, category FROM categories");
    return $statement->fetchAll();
  }
}
