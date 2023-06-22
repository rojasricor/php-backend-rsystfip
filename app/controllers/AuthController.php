<?php

namespace App\Controllers;

use Valitron\Validator;

use App\Models\UserModel;

class AuthController
{
  private UserModel $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel;
  }

  public function auth(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('Bad request');
    }

    $v = new Validator((array) $payload);
    $v->rule('required', ['username', 'password'])
      ->rule('lengthBetween', 'username', 5, 255)
      ->rule('lengthBetween', 'password', 8, 30);

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
    }

    $userAuth = $this->userModel->auth($payload->username . '@itfip.edu.co', $payload->password);

    if ($userAuth) {
      echo json_encode([
        'auth' => true,
        'user' => $userAuth
      ]);
      return;
    }

    echo json_encode([
      'errors' => ['auth' => 'Usuario o contraseña incorrectos'],
    ]);
  }

  public function validateSession(): void
  {
    $headers = getallheaders();
    $jwt = $headers['Authorization'] ?? '';

    if (!$jwt) {
      http_response_code(401);
      exit('Not session provided');
    }

    $response = $this->userModel->verifyJWT($jwt);
    $ok = $response['ok'] ?? false;

    if ($ok) {
      echo json_encode($response);
      return;
    }

    http_response_code(401);
    exit($response['message']);
  }
}
