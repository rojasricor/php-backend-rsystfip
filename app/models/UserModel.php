<?php

namespace App\Models;

class UserModel
{
  public static function getAll()
  {
    $db = DatabaseModel::get();
    $statement = $db->query("SELECT id, email FROM users");
    return $statement->fetchAll();
  }

  public static function getOneById($id)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT id, email, password FROM users WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public static function getOneByEmail($email)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("SELECT id, name, password, role, permissions FROM users WHERE email = ?");
    $statement->execute([$email]);
    return $statement->fetchObject();
  }

  public static function definePermissionsByRole($role) {
    $rector_permissions    = "schedule";
    $secretary_permissions = "$rector_permissions,add,reports,statistics";
    $admin_permissions     = "$secretary_permissions,admin";
    return $role === '2' ? $rector_permissions : $secretary_permissions;
  }

  public static function create($id, $cargo, $name, $lastname, $doctype, $document, $phone, $email, $password, $permissions)
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $db = DatabaseModel::get();
    $statement = $db->prepare("INSERT INTO users VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
    return $statement->execute([$id, $name, $lastname, $doctype, $document, $phone, $email,
    $hashedPassword, $cargo, $permissions]);
  }

  public static function delete($id)
  {
    $db = DatabaseModel::get();
    $statement = $db->prepare("DELETE FROM users WHERE id = ?");
    return $statement->execute([$id]);
  }

  public static function updatePassword($id, $password)
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $db = DatabaseModel::get();
    $statement = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $statement->execute([$hashedPassword, $id]);
  }

  public static function authById($id, $password)
  {
    $user = self::getOneById($id);
    return $user ? SecurityModel::verifyPassword($password, $user->password) : false;
  }

  public static function auth($email, $password)
  {
    $user = self::getOneByEmail($email);
    if ($user && SecurityModel::verifyPassword($password, $user->password)) {
      $permissions = explode(',', $user->permissions);
      return [
        'id' => $user->id,
        'role' => $user->role,
        'name' => $user->name,
        'email'=>$email,
        'permissions'=>$permissions
      ];
    }
  }
}
