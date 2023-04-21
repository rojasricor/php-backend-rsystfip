<?php

namespace App\Models;

use PDO;

class BaseModel
{
  protected $db;

  public function __construct() {
    $this->db = $this->createConnection();
  }
  
  public function createConnection()
  {
    $env = new EnvModel();
    $dsn = "mysql:host=". $env->get('HOST') . ";dbname=" . $env->get('DATABASE');
    $options = array(
      PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/certs/ca-certificates.crt"
    );
    $pdo = new PDO($dsn, $env->get('USERNAME'), $env->get('PASSWORD'));
    $pdo->query('set names utf8;');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $pdo;
  }
}
