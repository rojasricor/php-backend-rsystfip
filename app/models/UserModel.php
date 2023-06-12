<?php

namespace App\Models;

use DateTime;

class UserModel extends BaseModel
{
  public function getAll(): array
  {
    $statement = $this->db->query("SELECT id, email FROM users");
    return $statement->fetchAll();
  }

  public function getOneById(string $id): object | bool
  {
    $statement = $this->db->prepare("SELECT id, email, password FROM users WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public function getOneByEmail(string $email): object | bool
  {
    $statement = $this->db->prepare("SELECT id, name, password, role, permissions FROM users WHERE email = ?");
    $statement->execute([$email]);
    return $statement->fetchObject();
  }

  public function createPermissionsByRole(string $role): string
  {
    $rector_permissions    = "schedule";
    $secretary_permissions = "$rector_permissions,add,reports,statistics";
    $admin_permissions     = "$secretary_permissions,admin";
    return $role === '2' ? $rector_permissions : $secretary_permissions;
  }

  public function create(
    string $id,
    string $cargo,
    string $name,
    string $lastname,
    string $doctype,
    string $document,
    string $phone,
    string $email,
    string $password,
    string $permissions
  ): bool
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

  public function delete(string $id): bool
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE id = ?");
    return $statement->execute([$id]);
  }

  public function updatePasswordById(string $id, string $password): bool
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $statement->execute([$hashedPassword, $id]);
  }

  public function saveTokenResetPassword(string $token, string $expirationTime, string $email): bool
  {
    $statement = $this->db->prepare("UPDATE users SET reset_token = ?, reset_token_expiration = ? WHERE email = ?");
    return $statement->execute([$token, $expirationTime, $email]);
  }

  public function getDataResetToken(string $resetToken): object | bool
  {
    $statement = $this->db->prepare("SELECT email, reset_token_expiration FROM users WHERE reset_token = ?");
    $statement->execute([$resetToken]);
    return $statement->fetchObject();
  }

  public function deleteDataResetToken(string $resetToken): object | bool
  {
    $statement = $this->db->prepare("UPDATE users SET reset_token = NULL, reset_token_expiration = NULL WHERE reset_token = ?");
    return $statement->execute([$resetToken]);
  }

  public function verifyValidTokenReset(string $resetToken, string $email): array
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
    $currentDateTime    = new DateTime;
    $tokenIsValid       = $currentDateTime <= $expirationDateTime;

    return ['isValid' => $tokenIsValid];
  }

  public function updatePasswordByResetToken(string $resetToken, string $password): bool
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE reset_token = ?");
    return $statement->execute([$hashedPassword, $resetToken]);
  }

  public function authById(string $id, string $password): bool
  {
    $user = $this->getOneById($id);
    return $user ? SecurityModel::verifyPassword($password, $user->password) : false;
  }

  public function auth(string $email, string $password): array
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

    return [];
  }
}
