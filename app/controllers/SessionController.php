<?php

namespace App\controllers;

class SessionController
{
  static function logOut()
  {
    self::sessionStart();
    session_destroy();
  }

  static function sessionStart()
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
  }
}
