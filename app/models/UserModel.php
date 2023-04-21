<?php

namespace App\Models;

class UserModel extends BaseModel
{
  public function getAll()
  {
    $statement = $this->db->query("SELECT id, email FROM users");
    return $statement->fetchAll();
  }

  public function getOneById($id)
  {
    $statement = $this->db->prepare("SELECT id, email, password FROM users WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public function getOneByEmail($email)
  {
    $statement = $this->db->prepare("SELECT id, name, password, role, permissions FROM users WHERE email = ?");
    $statement->execute([$email]);
    return $statement->fetchObject();
  }

  public function definePermissionsByRole($role) {
    $rector_permissions    = "schedule";
    $secretary_permissions = "$rector_permissions,add,reports,statistics";
    $admin_permissions     = "$secretary_permissions,admin";
    return $role === '2' ? $rector_permissions : $secretary_permissions;
  }

  public function create($id, $cargo, $name, $lastname, $doctype, $document, $phone, $email, $password, $permissions)
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("INSERT INTO users VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
    return $statement->execute([$id, $name, $lastname, $doctype, $document, $phone, $email,
    $hashedPassword, $cargo, $permissions]);
  }

  public function delete($id)
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE id = ?");
    return $statement->execute([$id]);
  }

  public function updatePassword($id, $password)
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $statement->execute([$hashedPassword, $id]);
  }

  public function authById($id, $password)
  {
    $user = $this->getOneById($id);
    return $user ? SecurityModel::verifyPassword($password, $user->password) : false;
  }

  public function auth($email, $password)
  {
    $user = $this->getOneByEmail($email);
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
