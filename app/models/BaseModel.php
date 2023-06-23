<?php

namespace App\Models;

use PDO;

class BaseModel
{
  protected EnvModel $env;

  protected PDO $db;

  public function __construct()
  {
    $this->env = new EnvModel;
    $this->db = $this->createConnection();
  }

  private function createConnection(): PDO
  {
    $dsn = 'mysql:host=' . $this->env->get('HOST') . ';dbname=' . $this->env->get('DATABASE');
    $pdo = new PDO($dsn, $this->env->get('USERNAME'), $this->env->get('PASSWORD'), [
        PDO::ATTR_PERSISTENT => true, // Enable persistent connections
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    $pdo->query('set names utf8;');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
  }
}
