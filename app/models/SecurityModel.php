<?php

namespace App\Models;

class SecurityModel
{
  public static function preparePlainPassword($password): string
  {
    return hash("sha256", $password);
  }
  
  public static function hashPassword($password): string
  {
    return password_hash(self::preparePlainPassword($password), PASSWORD_BCRYPT);
  }

  public static function verifyPassword($password, $hash): bool
  {
    return password_verify(self::preparePlainPassword($password), $hash);
  }
}
