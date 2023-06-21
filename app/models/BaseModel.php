<?php

namespace App\Models;

use PDO;

class BaseModel
{
  private EnvModel $env;

  protected PDO $db;

  public function __construct()
  {
    $this->env = new EnvModel;
    $this->db = $this->createConnection();
  }
  
  private function createConnection(): PDO
  {
    $dsn = 'mysql:host=' . $this->env->get('HOST') . ';dbname=' . $this->env->get('DATABASE');
    $pdo = new PDO($dsn, $this->env->get('USERNAME'), $this->env->get('PASSWORD'));
    $pdo->query('set names utf8;');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $pdo;
  }
}
