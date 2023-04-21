<?php

namespace App\Models;

use PDO;

class DatabaseModel
{
  public static function get()
  {
    $dsn = "mysql:host=". EnvModel::get('HOST') . ";dbname=" . EnvModel::get('DATABASE');
    $options = array(
      PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/certs/ca-certificates.crt"
    );
    $pdo = new PDO($dsn, EnvModel::get('USERNAME'), EnvModel::get('PASSWORD'), $options);
    $pdo->query('set names utf8;');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $pdo;
  }
}
