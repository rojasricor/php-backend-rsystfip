<?php

namespace App\Models;

use DateTime;

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
    $statement = $this->db->prepare("INSERT INTO users (id, name, lastname, document_id, document_number, tel, email, password, role, permissions) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
    return $statement->execute([
      $id,
      $name,
      $lastname,
      $doctype,
      $document,
      $phone,
      $email,
      $hashedPassword,
      $cargo,
      $permissions
    ]);
  }

  public function delete($id)
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE id = ?");
    return $statement->execute([$id]);
  }

  public function updatePasswordById($id, $password)
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $statement->execute([$hashedPassword, $id]);
  }

  public function saveTokenResetPassword($token, $expirationTime, $email)
  {
    $statement = $this->db->prepare("UPDATE users SET reset_token = ?, reset_token_expiration = ? WHERE email = ?");
    return $statement->execute([$token, $expirationTime, $email]);
  }

  public function getDataResetToken($resetToken)
  {
    $statement = $this->db->prepare("SELECT email, reset_token_expiration FROM users WHERE reset_token = ?");
    $statement->execute([$resetToken]);
    return $statement->fetchObject();
  }

  public function deleteDataResetToken($resetToken)
  {
    $statement = $this->db->prepare("UPDATE users SET reset_token = NULL, reset_token_expiration = NULL WHERE reset_token = ?");
    return $statement->execute([$resetToken]);
  }

  public function verifyValidTokenReset($resetToken, $email)
  {
    date_default_timezone_set('America/Bogota');
    
    $resetTokenExists = $this->getDataResetToken($resetToken);

    if (!$resetTokenExists) {
      return [
        'error' => 'No has solicitado un cambio de contraseña, o acabas de cambiar tu contraseña con este link generado',
      ];
    }

    if ($resetTokenExists->email !== $email) {
      return [
        'error' => 'El correo proporcionado no coincide con el correo del usuario',
      ];
    }

    $resetTokenExpiration = $resetTokenExists->reset_token_expiration;

    $expirationDateTime = new DateTime($resetTokenExpiration);
    $currentDateTime    = new DateTime();
    $tokenIsValid       = $currentDateTime <= $expirationDateTime;

    return ['isValid' => $tokenIsValid];
  }

  public function updatePasswordByResetToken($resetToken, $password)
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE reset_token = ?");
    return $statement->execute([$hashedPassword, $resetToken]);
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
