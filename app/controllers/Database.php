<?php

namespace App\Controllers;

use PDO;

class Database
{
  static function get()
  {
    $pass = Env::get('MYSQL_PSW');
    $user = Env::get('MYSQL_USER');
    $dnam = Env::get('MYSQL_DB');
    $host = Env::get('MYSQL_HOST');
    $dbas = new PDO("mysql:host=$host;dbname=$dnam", $user, $pass);
    $dbas->query('set names utf8;');
    $dbas->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbas->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbas->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $dbas;
  }
}
