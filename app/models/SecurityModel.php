<?php

namespace App\Models;

class SecurityModel
{
  public static function preparePlainPassword($password)
  {
    return hash("sha256", $password);
  }
  
  public static function hashPassword($password)
  {
    return password_hash(self::preparePlainPassword($password), PASSWORD_BCRYPT);
  }

  public static function verifyPassword($password, $hash)
  {
    return password_verify(self::preparePlainPassword($password), $hash);
  }
}
