<?php

namespace App\Models;

use PDO;

class DatabaseModel
{
  public static function get()
  {
    $pass = EnvModel::get('MYSQL_PSW');
    $user = EnvModel::get('MYSQL_USER');
    $dnam = EnvModel::get('MYSQL_DB');
    $host = EnvModel::get('MYSQL_HOST');
    $dbas = new PDO("mysql:host=$host;dbname=$dnam", $user, $pass);
    $dbas->query('set names utf8;');
    $dbas->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbas->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbas->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $dbas;
  }
}
