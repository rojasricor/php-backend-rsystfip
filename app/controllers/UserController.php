<?php

namespace App\Controllers;

use Valitron\Validator;

use App\Models\{
  UserModel,
  EmailSenderModel
};

class UserController
{
  private UserModel $userModel;
  
  public function __construct()
  {
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

    $v = new Validator((array) $payload);
    $v->rule('required', [
      'role',
      'name',
      'lastname',
      'docType',
      'doc',
      'tel',
      'email',
      'password',
      'passwordConfirmation'
    ])->rule('notIn', 'role', ['unset'])
      ->rule('notIn', 'docType', ['unset'])
      ->rule('lengthBetween', 'doc', 8, 10)
      ->rule('email', 'email')
      ->rule('length', 'tel', 10)
      ->rule('lengthBetween', 'password', 8, 30)
      ->rule('lengthBetween', 'passwordConfirmation', 8, 30)
      ->rule('equals', 'password', 'passwordConfirmation');

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
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

    $domainRequired   = 'itfip.edu.co';
    $domainToValidate = explode('@', $email)[1];

    if ($domainToValidate !== $domainRequired) {
      echo json_encode(['errors' => [
        'error' => 'El correo proporcionado no es del dominio ' . $domainRequired
      ]]);
      return;
    }

    $id = $role - 1;
    $roleExists = $this->userModel->getOneById($id);

    if ($roleExists) {
      echo json_encode([
        'errors' => [
          'error' => 'El cargo seleccionado ya ha sido asignado a otro usuario'
        ]
      ]);
      return;
    }

    $emailExists = $this->userModel->getOneByEmail($email);

    if ($emailExists) {
      echo json_encode([
        'errors' => [
          'error' => 'El correo proporcionado ya esta registrado en nombre de otro usuario'
        ]
      ]);
      return;
    }

    $ok = $this->userModel->create($id, $role, $name, $lastname, $documentType, $document, $telephone, $email, $password);

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

    $v = new Validator((array) $payload);
    $v->rule('required', [
      'email',
      'resetToken',
      'password',
      'password_confirm'
    ])->rule('equals', 'password', 'password_confirm')
      ->rule('lengthBetween', 'password', 8, 30)
      ->rule('lengthBetween', 'password_confirm', 8, 30);

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
    }

    $email      = $payload->email;
    $resetToken = $payload->resetToken;
    $password   = $payload->password;
    $password2  = $payload->password_confirm;

    $tokenIsValid = $this->userModel->verifyValidTokenReset($resetToken, $email);

    if ($tokenIsValid['error'] ?? false) {
      echo json_encode([
        'tokenIsValid' => false,
        'errors' => [
          'error' => $tokenIsValid['error']
        ]
      ]);
      return;
    }

    $passwordChangedSuccessfully = $this->userModel->updatePasswordByResetToken($resetToken, $password);
    $ok = $this->userModel->deleteDataResetToken($resetToken, $email);

    if (!$passwordChangedSuccessfully || !$ok) {
      echo json_encode([
        'errors' => [
          'error' => 'No se pudo cambiar la contraseña, intente nuevamente'
        ]
      ]);
      return;
    }

    echo json_encode([
      'ok' => 'Contraseña cambiada exitosamente',
    ]);
  }
  
  public function verifyResetToken(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $resetToken = $payload->resetToken;
    $email = $payload->email;

    $tokenIsValid = $this->userModel->verifyValidTokenReset($resetToken, $email);

    if ($tokenIsValid['error'] ?? false) {
      echo json_encode([
        'tokenIsValid' => false,
        'error' => $tokenIsValid['error'],
      ]);
      return;
    }

    echo json_encode(['tokenIsValid' => $tokenIsValid['isValid']]);
  }

  public function deleteResetToken(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $resetToken = $payload->resetToken;

    $this->userModel->deleteDataResetToken($resetToken);
  }

  public function recoverPassword(): void
  {
    date_default_timezone_set('America/Bogota');
    
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $v = new Validator((array) $payload);
    $v->rule('required', ['email', 'APP_ROUTE'])
      ->rule('email', 'email');

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
    }

    $email = $payload->email;
    $APP_ROUTE = $payload->APP_ROUTE;

    $emailIsRegistered = $this->userModel->getOneByEmail($email);

    if (!$emailIsRegistered) {
      echo json_encode([
        'errors' => [
          'error' => 'El correo electrónico no está registrado'
        ]
      ]);
      return;
    }

    $tokenLength = 16;
    $randomBytes = random_bytes($tokenLength);
    $token = bin2hex($randomBytes);
    $expirationTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    $tokenResetSaved = $this->userModel->saveTokenResetPassword($token, $expirationTime, $email);

    if (!$tokenResetSaved) {
      echo json_encode([
        'errors' => [
          'error' => 'Error al guardar el token de recuperación de contraseña'
        ]
      ]);
      return;
    }

    $resetPasswordLink = $APP_ROUTE . '/' . $email . '/' . $token;

    $emailSenderModel = new EmailSenderModel;
    $message = 'Estimado usuario, hemos recibido una solicitud de cambio de contraseña para su cuenta. Si no ha sido usted, por favor ignore este correo electrónico.<br>Si es así, por favor ingrese al siguiente link para restablecer su contraseña:<br>' . $resetPasswordLink . '<br><strong>Este link expirará en 10 minutos.</strong><br><br>Saludos, <br>Equipo ITFIP - RSystfip';

    $linkSended = $emailSenderModel->sendEmail(
      "Solicitud de cambio de contraseña",
      $email,
      $message
    );

    if ($linkSended['response'] ?? false) {
      echo json_encode([
        'ok' => $emailIsRegistered->name . ", hemos enviado un email con instrucciones a su correo electrónico: $email!. Expira en 10 minutos.",
      ]);
      return;
    }

    echo json_encode([
      'errors' => $linkSended['errors']
    ]);
  }

  public function updatePassword(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $v = new Validator((array) $payload);
    $v->rule('required', [
      'id',
      'current_password',
      'new_password',
      'new_password_confirm'
    ])->rule('equals', 'new_password', 'new_password_confirm')
      ->rule('lengthBetween', 'new_password', 8, 30)
      ->rule('lengthBetween', 'new_password_confirm', 8, 30);

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
    }

    $id = $payload->id;
    $currentPassword = $payload->current_password;
    $newPassword = $payload->new_password;
    $password2 = $payload->new_password_confirm;

    if (!$this->userModel->authById($id, $currentPassword)) {
      echo json_encode([
        'errors' => [
          'auth' => 'La contraseña antigua es incorrecta'
        ],
      ]);
      return;
    }

    $ok = $this->userModel->updatePasswordById($id, $newPassword);

    if (!$ok) {
      echo json_encode([
        'errors' => [
          'error' => 'No se pudo cambiar la contraseña, intente nuevamente.'
        ]
      ]);
      return;
    }

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

    $roleId = $payload->roleId;

    $userDeleted = $this->userModel->delete($roleId);

    if (!$userDeleted) {
      echo json_encode([
        'error' => 'Error al eliminar, intente nuevamente.'
      ]);
      return;
    }

    echo json_encode([
      'ok' => 'Usuario eliminado exitosamente'
    ]);
  }
}
