<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController
{
  private UserModel $userModel;
  
  public function __construct() {
    $this->userModel = new UserModel();
  }
  
  public function getUsers(): void
  {
    echo json_encode($this->userModel->getAll());
  }

  public function getUser(): void
  {
    if (!isset($_GET['role'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $user = $this->userModel->getOneById($_GET['role']);
    
    if (!$user) {
      http_response_code(404);
      exit('not found');
    }
    
    echo json_encode($user);
  }

  public function saveUser(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $role                 = $payload->role;
    $name                 = ucwords(strtolower($payload->name));
    $lastname             = ucwords(strtolower($payload->lastname));
    $documentType         = $payload->docType;
    $document             = $payload->doc;
    $telephone            = $payload->tel;
    $email                = strtolower($payload->email);
    $password             = $payload->password;
    $passwordConfirmation = $payload->passwordConfirmation;

    if ($role !== '2' && $role !== '3') {
      echo json_encode([
        'error' => 'Selecciona el cargo del nuevo usuario',
      ]);
      return;
    }

    if (empty($name)) {
      echo json_encode(['error' => 'Complete el campo nombre']);
      return;
    }

    if (!ctype_alpha($name) && ctype_space($name)) {
      echo json_encode(['error' => 'El nombre no debe contener letras']);
      return;
    }

    if (is_numeric($name)) {
      echo json_encode(['error' => 'El nombre no puede ser numérico']);
      return;
    }

    if (empty($lastname)) {
      echo json_encode(['error' => 'Complete el campo apellido']);
      return;
    }

    if (!ctype_alpha($lastname) && ctype_space($lastname)) {
      echo json_encode(['error' => 'El apellido no debe contener letras']);
      return;
    }

    if (is_numeric($lastname)) {
      echo json_encode(['error' => 'El apellido no puede ser numérico']);
      return;
    }

    if ($documentType === 'unset' || empty($documentType)) {
      echo json_encode([
        'error' => 'Selecciona el tipo de documento',
      ]);
      return;
    }

    if (!is_numeric($document) || empty($document)) {
      echo json_encode(['error' => 'Ingrese el número de documento']);
      return;
    }

    if (strlen($document) < 8 || strlen($document) > 10) {
      echo json_encode(['error' => 'El número de documento debe tener entre 8 y 10 caracteres']);
      return;
    }

    if (empty($email)) {
      echo json_encode(['error' => 'Ingrese el correo institucional']);
      return;
    }

    if (is_numeric($email)) {
      echo json_encode(['error' => 'El correo institucional no puede ser sólo números']);
      return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['error' => 'La dirección de correo electrónico no es válida']);
      return;
    }

    $domainRequired   = 'itfip.edu.co';
    $domainToValidate = explode('@', $email)[1];

    if ($domainToValidate !== $domainRequired) {
      echo json_encode(['error' => 'El correo proporcionado no es del dominio ' . $domainRequired]);
      return;
    }

    if (!is_numeric($telephone) || empty($telephone)) {
      echo json_encode(['error' => 'Ingrese el número de teléfono']);
      return;
    }

    if (strlen($telephone) !== 10) {
      echo json_encode(['error' => 'El número de celular debe tener 10 dígitos, si usted no es de Colombia ingrese 10 veces 1 para continuar']);
      return;
    }

    if (empty($password)) {
      echo json_encode(['error' => 'Complete campo contraseña']);
      return;
    }

    if (empty($passwordConfirmation)) {
      echo json_encode(['error' => 'Complete campo confirmación de contraseña']);
      return;
    }

    if (strlen($password) < 8 || strlen($passwordConfirmation) < 8) {
      echo json_encode(['error' => 'La contraseña es insegura debe tener al menos 8 caracteres']);
      return;
    }

    if ($password !== $passwordConfirmation) {
      echo json_encode([
        'error' => 'Las contraseñas no coinciden, password != passwordConfirmation',
      ]);
      return;
    }

    $id = $role - 1;
    $roleExists = $this->userModel->getOneById($id);

    if ($roleExists) {
      echo json_encode([
        'error' => 'El cargo seleccionado ya ha sido asignado a otro usuario',
      ]);
      return;
    }

    $emailExists = $this->userModel->getOneByEmail($email);

    if ($emailExists) {
      echo json_encode([
        'error' => 'El correo proporcionado ya esta registrado en nombre de otro usuario',
      ]);
      return;
    }

    $permissions = $this->userModel->definePermissionsByRole($role);
    $ok = $this->userModel->create($id, $role, $name, $lastname, $documentType, $document, $telephone, $email, $password, $permissions);

    if ($ok) {
      echo json_encode([
        'ok' => 'Usuario agregado exitosamente!',
      ]);
    }
  }

  public function updateAndRecoverPassword(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $email      = $payload->email;
    $resetToken = $payload->resetToken;
    $password   = $payload->password;
    $password2  = $payload->password_confirm;

    if ($password !== $password2) {
      echo json_encode([
        'error' => 'Las contraseñas no coinciden',
      ]);
      return;
    }

    if (strlen($password) < 8 || strlen($password2) < 8) {
      echo json_encode([
        'error' => 'La contraseña es insegura debe tener al menos 8 caracteres',
      ]);
      return;
    }

    $tokenIsValid = $this->userModel->verifyValidTokenReset($resetToken, $email);

    if ($tokenIsValid['error'] ?? false) {
      echo json_encode([
        'tokenIsValid' => false,
        'error' => $tokenIsValid['error'],
      ]);
      return;
    }

    $passwordChangedSuccessfully = $this->userModel->updatePasswordByResetToken($resetToken, $password);

    if (!$passwordChangedSuccessfully) {
      echo json_encode([
        'error' => 'No se pudo cambiar la contraseña, intente nuevamente',
      ]);
      return;
    }

    $this->userModel->deleteDataResetToken($resetToken, $email);

    echo json_encode([
      'ok' => 'Contraseña cambiada exitosamente',
    ]);
  }

  public function updatePassword(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $id                 = $payload->id;
    $currentPassword    = $payload->current_password;
    $newPassword        = $payload->new_password;
    $confirmNewPassword = $payload->new_password_confirm;

    if ($newPassword !== $confirmNewPassword) {
      echo json_encode([
        'error' => 'La nueva contraseña no coincide con la confirmación',
      ]);
      return;
    }

    if (strlen($newPassword) < 8 || strlen($confirmNewPassword) < 8) {
      echo json_encode([
        'error' => 'La contraseña es insegura debe tener al menos 8 caracteres',
      ]);
      return;
    }

    if (!$this->userModel->authById($id, $currentPassword)) {
      echo json_encode([
        'error' => 'La contraseña antigua es incorrecta',
      ]);
      return;
    }

    $this->userModel->updatePasswordById($id, $newPassword);
    echo json_encode([
      'ok' => 'Contraseña cambiada exitosamente',
    ]);
  }

  public function deleteUser(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $role = $payload->role;

    echo json_encode($this->userModel->delete($role));
  }
}
