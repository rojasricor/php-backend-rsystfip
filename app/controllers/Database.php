<?php

namespace App\controllers;

use PDO;

class Database
{
  static function get()
  {
    $pass = Utils::getEnv('MYSQL_PSW');
    $user = Utils::getEnv('MYSQL_USER');
    $dnam = Utils::getEnv('MYSQL_DB');
    $host = Utils::getEnv('MYSQL_HOST');
    $dbas = new PDO("mysql:host=$host;dbname=$dnam", $user, $pass);
    $dbas->query('set names utf8;');
    $dbas->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbas->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbas->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $dbas;
  }
}
