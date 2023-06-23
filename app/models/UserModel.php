<?php

namespace App\Models;

use DateTime;

use Firebase\JWT\{
  JWT,
  Key
};

use UnexpectedValueException;

class UserModel extends BaseModel
{
  public function getAll(): array
  {
    $statement = $this->db->query("SELECT id, name, lastname, tel, email, role FROM users");
    return $statement->fetchAll();
  }

  public function getOneById(string $id): object | bool
  {
    $statement = $this->db->prepare("SELECT id, email FROM users WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
  }

  public function getOneByIdForAuth(string $id): object | bool
  {
    $statement = $this->db->prepare("SELECT id, email, password, role, permissions FROM users WHERE id = ?");
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
    // schedule: rector, secretary, admin
    // add: secretary, admin
    // reports: secretary, admin
    // statistics: secretary, admin
    // admin: admin
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
    $statement->execute([
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
    return $statement->rowCount() > 0;
  }

  public function delete(string $id): bool
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE id = ?");
    $statement->execute([$id]);
    return $statement->rowCount() > 0;
  }

  public function updatePasswordById(string $id, string $password): bool
  {
    $hashedPassword = SecurityModel::hashPassword($password);
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $statement->execute([$hashedPassword, $id]);
    return $statement->rowCount() > 0;
  }

  public function saveTokenResetPassword(string $token, string $expirationTime, string $email): bool
  {
    $statement = $this->db->prepare("UPDATE users SET reset_token = ?, reset_token_expiration = ? WHERE email = ?");
    $statement->execute([$token, $expirationTime, $email]);
    return $statement->rowCount() > 0;
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
    $statement->execute([$resetToken]);
    return $statement->rowCount() > 0;
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
    $statement->execute([$hashedPassword, $resetToken]);
    return $statement->rowCount() > 0;
  }

  public function authById(string $id, string $password): bool
  {
    $user = $this->getOneByIdForAuth($id);
    return $user ? SecurityModel::verifyPassword($password, $user->password) : false;
  }

  public function generateTokenJWT(array $dataToJoin, int $exp): string
  {
    $payload = array_merge([
      'iat' => time(),
      'exp' => time() + $exp
    ], $dataToJoin);

    $secretKey = $this->env->get('SECRET_KEY');

    return JWT::encode($payload, $secretKey, 'HS256');
  }

  public function verifyJWT(string $jwt): array
  {
    $secretKey = $this->env->get('SECRET_KEY');

    try {
      $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
      return [
        'ok' => [
          'isValid' => true,
          'decoded' => (array) $decoded
        ]
      ];
    } catch (UnexpectedValueException $e) {
      $errorMessage = "Session invalid or expired";

      return [
        'message' => $errorMessage
      ];
    }
  }

  public function auth(string $email, string $password): array
  {
    $user = $this->getOneByEmail($email);
    if ($user && SecurityModel::verifyPassword($password, $user->password)) {
      $permissions = explode(',', $user->permissions);
      $exp = (7 * 24 * 60 * 60); // time in seconds

      $token = $this->generateTokenJWT([
        'id' => $user->id,
        'email' => $email,
        'role' => $user->role,
        'permissions' => $permissions,
        'iat' => time(),
        'exp' => time() + $exp
      ], $exp);
      
      header('Access-Control-Expose-Headers: Authorization');
      header("Authorization: $token");
      
      return [
        'id' => $user->id,
        'role' => $user->role,
        'name' => $user->name,
        'email'=> $email,
        'permissions'=> $permissions
      ];
    }

    return [];
  }
}
