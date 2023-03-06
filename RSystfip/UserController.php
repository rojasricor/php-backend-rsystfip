<?php

namespace RSystfip;

class UserController
{
  static function getUsersDashboard()
  {
    $db = Database::get();
    $statement = $db->query("SELECT id, email FROM rsystfip_users");
    return $statement->fetchAll();
  }

  static function getOneById($id)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT id, email, password FROM rsystfip_users WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  static function getOneByEmail($email)
  {
    $db = Database::get();
    $statement = $db->prepare("SELECT id, name, password, role, permissions FROM rsystfip_users WHERE email = ?");
    $statement->execute([$email]);
    return $statement->fetchObject();
  }

  static function definePermissionsByRole($role) {
    $rector_permissions    = "schedule";
    $secretary_permissions = "$rector_permissions,add,reports,statistics";
    $admin_permissions     = "$secretary_permissions,admin";
    return $role === '2' ? $rector_permissions : $secretary_permissions;
  }

  static function create($id, $cargo, $name, $lastname, $doctype, $document, $phone, $email, $password, $permissions)
  {
    $hashedPassword = Security::hashPassword($password);
    $db = Database::get();
    $statement = $db->prepare("INSERT INTO rsystfip_users VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
    return $statement->execute([$id, $name, $lastname, $doctype, $document, $phone, $email,
    $hashedPassword, $cargo, $permissions]);
  }

  static function delete($id)
  {
    $db = Database::get();
    $statement = $db->prepare("DELETE FROM rsystfip_users WHERE id = ?");
    return $statement->execute([$id]);
  }

  static function updatePassword($id, $password)
  {
    $hashedPassword = Security::hashPassword($password);
    $db = Database::get();
    $statement = $db->prepare("UPDATE rsystfip_users SET password = ? WHERE id = ?");
    $statement->execute([$hashedPassword, $id]);
  }

  static function authById($id, $password)
  {
    $user = self::getOneById($id);
    return $user ? Security::verifyPassword($password, $user->password) : false;
  }

  static function auth($email, $password)
  {
    $user = self::getOneByEmail($email);
    if ($user && Security::verifyPassword($password, $user->password)) {
      $permissions = explode(',', $user->permissions);
      return [
        'id' => $user->id,
        'role' =>  $user->role,
        'name' => $user->name,
        'email'=>$email,
        'permissions'=>$permissions
      ];
    }
  }
}
