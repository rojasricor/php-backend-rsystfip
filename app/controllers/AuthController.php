<?php

namespace App\Controllers;

use App\Models\{
  UserModel,
  EmailSenderModel
};

class AuthController
{
  private UserModel $userModel;

  public function __construct() {
    $this->userModel = new UserModel;
  }

  public function auth(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $username = $payload->username;
    $password = $payload->password;

    if (empty($username)) {
      echo json_encode([
        'error' => 'Complete el usuario',
      ]);
      return;
    }

    if (empty($password)) {
      echo json_encode([
        'error' => 'Complete la contraseña',
      ]);
      return;
    }

    if (strlen($password) < 8) {
      echo json_encode([
        'error' => 'Contraseña demasiado corta',
      ]);
      return;
    }

    if (strlen($password) > 30) {
      echo json_encode([
        'error' => 'Contraseña inválida',
      ]);
      return;
    }
    
    $userAuth = $this->userModel->auth("$username@itfip.edu.co", $password);
    
    if ($userAuth) {
      echo json_encode([
        'auth' => true,
        'user' => $userAuth,
      ]);
      return;
    }

    echo json_encode([
      'error' => 'Credenciales incorrectas',
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

    $email = $payload->email;
    $APP_ROUTE = $payload->APP_ROUTE;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode([
        'error' => 'El correo electrónico no es válido',
      ]);
      return;
    }

    $emailIsRegistered = $this->userModel->getOneByEmail($email);

    if (!$emailIsRegistered) {
      echo json_encode([
        'error' => 'El correo electrónico no está registrado',
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
         'error' => 'Error al guardar el token de recuperación de contraseña',
      ]);
      return;
    }

    $resetPasswordLink = "$APP_ROUTE/$email/$token";

    $emailSenderModel = new EmailSenderModel;
    $message = 'Estimado usuario, hemos recibido una solicitud de cambio de contraseña para su cuenta. Si no ha sido usted, por favor ignore este correo electrónico.<br>Si es así, por favor ingrese al siguiente link para restablecer su contraseña:<br>' . $resetPasswordLink . '<br><strong>Este link expirará en 10 minutos.</strong><br><br>Saludos, <br>Equipo ITFIP - RSystfip';

    $linkSended = $emailSenderModel->sendEmail(
      "Solicitud de cambio de contraseña",
      $email,
      $message
    );

    if ($linkSended) {
      echo json_encode([
        'ok' => $emailIsRegistered->name . ", hemos enviado un email con instrucciones a su correo electrónico: $email!. Expira en 10 minutos.",
      ]);
    }
  }
}
