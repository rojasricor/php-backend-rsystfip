<?php

namespace App\Controllers;

use Exception;

class Env
{
  static function get($key)
  {
    if (defined('_ENV_CACHE')) {
      $vars = _ENV_CACHE;
    } else {
      $file = 'app/env/env.php';
      if (!file_exists($file)) {
        throw new Exception("The environment file ($file) does not exists. Please create it");
      }
      $vars = parse_ini_file($file);
      define('_ENV_CACHE', $vars);
    }
    if (isset($vars[$key])) {
      return $vars[$key];
    } else {
      throw new Exception("The specified key ($key) does not exist in the environment file");
    }
  }
}
